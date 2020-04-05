<?php

declare(strict_types=1);

/**
 * @copyright C UAB NFQ Technologies
 *
 * This Software is the property of NFQ Technologies
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB NFQ Technologies:
 * E-mail: info@nfq.lt
 * http://www.nfq.lt
 *
 */


namespace App\Service;

use App\Eimmar\GameSpotBundle\DTO\Request\ApiRequest;
use App\Eimmar\GameSpotBundle\DTO\Response\Response;
use App\Eimmar\GameSpotBundle\Service\ApiConnector;
use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;

class GameSpotAdapter
{
    private ApiConnector $apiConnector;

    private EntityManagerInterface $entityManager;

    /**
     * @param ApiConnector $apiConnector
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ApiConnector $apiConnector, EntityManagerInterface $entityManager)
    {
        $this->apiConnector = $apiConnector;
        $this->entityManager = $entityManager;
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
//        return $apiCallbackFunc === 'review' ? ['title' => $game->getName() . ' Review'] : ['association' => $game->getGameSpotAssociation()];
        return $apiCallbackFunc === 'review' ? ['title' => 'Black'] : ['association' => $game->getGameSpotAssociation()];
    }

    public function get(string $apiCallbackFunc, Game $game, ApiRequest $apiRequest): Response
    {
        if (!$game->getGameSpotAssociation()) {
            $response = $this->apiConnector->games(new ApiRequest('json', ['name' => $game->getName()]));

            foreach ($response->getResults() as $result) {
                if ($result->getName() === $game->getName()) {
                    $game->setGameSpotAssociation($this->getAssociation($result));
                    $this->entityManager->persist($game);
                    $this->entityManager->flush();
                    break;
                }
            }
        }

        if ($game->getGameSpotAssociation()) {
            $response = $this->apiConnector->$apiCallbackFunc(new ApiRequest(
                $apiRequest->getFormat(),
                $this->getCriteria($apiCallbackFunc, $game),
                $apiRequest->getFieldList(),
                $apiRequest->getLimit(),
                $apiRequest->getOffset(),
                $apiRequest->getSort()
            ));
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
