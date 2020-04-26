<?php

declare(strict_types=1);

namespace App\Service\API;

use App\Eimmar\GameSpotBundle\DTO\Request\ApiRequest;
use App\Eimmar\GameSpotBundle\DTO\Response\Response;
use App\Eimmar\GameSpotBundle\Service\ApiConnector;
use App\Entity\Game;
use App\Service\CacheService;
use Doctrine\ORM\EntityManagerInterface;

class GameSpotAdapter
{
    const CACHE_TAG = 'gameSpot';

    private ApiConnector $apiConnector;

    private EntityManagerInterface $entityManager;

    private CacheService $cache;

    /**
     * @param ApiConnector $apiConnector
     * @param EntityManagerInterface $entityManager
     * @param CacheService $cache
     */
    public function __construct(ApiConnector $apiConnector, EntityManagerInterface $entityManager, CacheService $cache)
    {
        $this->apiConnector = $apiConnector;
        $this->entityManager = $entityManager;
        $this->cache = $cache;
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

    private function getCriteria(string $apiCallbackFunc, Game $game): array
    {
        return $apiCallbackFunc === 'reviews' ? ['title' => $game->getName() . ' Review'] : ['association' => $game->getGameSpotAssociation()];
    }

    private function setGameSpotAssociation(Game $game)
    {
        $apiRequest = new ApiRequest('json', ['name' => $game->getName()]);
        $key = implode("_", $apiRequest->unwrap());
        $callback = function (Game $game) {
            return $this->apiConnector->games(new ApiRequest('json', ['name' => $game->getName()]));
        };

        $response = $this->cache->getItem(self::CACHE_TAG . 'games', $key, $callback, [$game]);

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
            $apiRequest->setFilter($this->getCriteria($apiCallbackFunc, $game));
            $key = implode("_", $apiRequest->unwrap()) . '_' . $apiCallbackFunc;

            $callback = function (ApiRequest $request, $apiCallbackFunc) {
                return $this->apiConnector->$apiCallbackFunc($request);
            };

            $response = $this->cache->getItem(
                self::CACHE_TAG . $apiCallbackFunc,
                $key,
                $callback,
                [$apiRequest, $apiCallbackFunc]
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
