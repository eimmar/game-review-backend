<?php

declare(strict_types=1);

namespace App\Service;

use App\Eimmar\GameSpotBundle\DTO\Request\ApiRequest;
use App\Eimmar\GameSpotBundle\DTO\Response\Response;
use App\Eimmar\GameSpotBundle\Service\ApiConnector;
use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class GameSpotAdapter
{
    const CACHE_TAG = 'gameSpot';

    private ApiConnector $apiConnector;

    private EntityManagerInterface $entityManager;

    private TagAwareAdapter $cache;

    private int $cacheLifeTime;

    /**
     * @param ApiConnector $apiConnector
     * @param EntityManagerInterface $entityManager
     * @param int $cacheLifeTime
     */
    public function __construct(ApiConnector $apiConnector, EntityManagerInterface $entityManager, int $cacheLifeTime)
    {
        $this->apiConnector = $apiConnector;
        $this->entityManager = $entityManager;
        $this->cacheLifeTime = $cacheLifeTime;
        $this->cache = new TagAwareAdapter(new FilesystemAdapter(), new FilesystemAdapter());
    }

    private function getAssociation(\App\Eimmar\GameSpotBundle\DTO\Game $game): ?string
    {
        $apiUrls = [$game->getArticlesApiUrl(), $game->getImagesApiUrl(), $game->getReleasesApiUrl(), $game->getReviewsApiUrl(), $game->getVideosApiUrl()];
        foreach ($apiUrls as $url) {
            if (is_string($url) && count($parts = explode(':', urldecode(($game->getReviewsApiUrl())))) === 3) {
                return end($parts);
            }
        }

        return null;
    }

    private function getCacheKey(string $apiCallbackFunc, ApiRequest $apiRequest)
    {
        return str_replace(['{', '}', '(',')','/','\\','@', ':', ' '], '', self::CACHE_TAG . '.' . $apiCallbackFunc . '.' . implode("_", $apiRequest->unwrap()));
    }

    private function getCriteria(string $apiCallbackFunc, Game $game): array
    {
        return $apiCallbackFunc === 'reviews' ? ['title' => $game->getName() . ' Review'] : ['association' => $game->getGameSpotAssociation()];
    }

    private function setGameSpotAssociation(Game $game)
    {
        $apiRequest = new ApiRequest('json', ['name' => $game->getName()]);

        $response = $this->cache->get(
            $this->getCacheKey('games', $apiRequest),
            function (ItemInterface $item) use ($apiRequest, $game) {
                $item->expiresAfter($this->cacheLifeTime);
                $item->tag([self::CACHE_TAG . 'games']);

                return $this->apiConnector->games(new ApiRequest('json', ['name' => $game->getName()]));
            }
        );

        foreach ($response->getResults() as $result) {
            if ($result->getName() === $game->getName()) {
                $game->setGameSpotAssociation($this->getAssociation($result));
                $this->entityManager->persist($game);
                $this->entityManager->flush();
                break;
            }
        }
    }

    public function get(string $apiCallbackFunc, Game $game, ApiRequest $apiRequest): Response
    {
        if (!$game->getGameSpotAssociation()) {
            $this->setGameSpotAssociation($game);
        }

        if ($game->getGameSpotAssociation()) {
            $response = $this->cache->get(
                $this->getCacheKey($apiCallbackFunc, $apiRequest) . '_' . $game->getId(),
                function (ItemInterface $item) use ($apiRequest, $apiCallbackFunc, $game) {
                    $item->expiresAfter($this->cacheLifeTime);
                    $item->tag([self::CACHE_TAG . $apiCallbackFunc]);

                    return $this->apiConnector->$apiCallbackFunc(new ApiRequest(
                        $apiRequest->getFormat(),
                        $this->getCriteria($apiCallbackFunc, $game),
                        $apiRequest->getFieldList(),
                        $apiRequest->getLimit(),
                        $apiRequest->getOffset(),
                        $apiRequest->getSort()
                    ));
                }
            );
        } else {
            $response = new Response(
                'OK',
                $apiRequest->getLimit() ?: 100,
                $apiRequest->getOffset() ?: 0,
                0,
                0,
                1,
                [],
                '1.0'
            );
        }

        return $response;
    }
}
