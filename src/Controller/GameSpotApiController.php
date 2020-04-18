<?php

declare(strict_types=1);

namespace App\Controller;

use App\Eimmar\GameSpotBundle\DTO\Request\ApiRequest;
use App\Entity\Game;
use App\Service\GameSpotAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/game-spot")
 */
class GameSpotApiController extends BaseApiController
{
    /**
     * @Route("/reviews/{id}", name="game_spot_game_reviews_options", methods={"OPTIONS"})
     * @Route("/videos/{id}", name="game_spot_game_videos_options", methods={"OPTIONS"})
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
}
