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


namespace App\Controller;

use App\Eimmar\GameSpotBundle\DTO\Request\ApiRequest;
use App\Entity\Game;
use App\Service\GameSpotAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/game-spot")
 */
class GameSpotApiController extends BaseApiController
{
    /**
     * @Route("/reviews/{id}", name="game_spot_game_reviews_options", methods={"OPTIONS"})
     * @Route("/articles/{id}", name="game_spot_game_articles_options", methods={"OPTIONS"})
     * @Route("/videos/{id}", name="game_spot_game_videos_options", methods={"OPTIONS"})
     * @Route("/images/{id}", name="game_spot_game_images_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/reviews/{id}", name="game_spot_game_reviews", methods={"POST"})
     * @param GameSpotAdapter $gameSpotAdapter
     * @param Game $game
     * @param ApiRequest $apiRequest
     * @return JsonResponse
     */
    public function reviews(GameSpotAdapter $gameSpotAdapter, Game $game, ApiRequest $apiRequest): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($gameSpotAdapter->get('reviews', $game, $apiRequest));
    }

    /**
     * @Route("/articles/{id}", name="game_spot_game_articles", methods={"POST"})
     * @param GameSpotAdapter $gameSpotAdapter
     * @param Game $game
     * @param ApiRequest $apiRequest
     * @return JsonResponse
     */
    public function articles(GameSpotAdapter $gameSpotAdapter, Game $game, ApiRequest $apiRequest): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($gameSpotAdapter->get('articles', $game, $apiRequest));
    }

    /**
     * @Route("/videos/{id}", name="game_spot_game_videos", methods={"POST"})
     * @param GameSpotAdapter $gameSpotAdapter
     * @param Game $game
     * @param ApiRequest $apiRequest
     * @return JsonResponse
     */
    public function videos(GameSpotAdapter $gameSpotAdapter, Game $game, ApiRequest $apiRequest): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($gameSpotAdapter->get('videos', $game, $apiRequest));
    }

    /**
     * @Route("/images/{id}", name="game_spot_game_images", methods={"POST"})
     * @param GameSpotAdapter $gameSpotAdapter
     * @param Game $game
     * @param ApiRequest $apiRequest
     * @return JsonResponse
     */
    public function images(GameSpotAdapter $gameSpotAdapter, Game $game, ApiRequest $apiRequest): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($gameSpotAdapter->get('images', $game, $apiRequest));
    }
}
