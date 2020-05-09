<?php

declare(strict_types=1);

namespace App\Controller;

use App\Eimmar\GameSpotBundle\DTO\Request\ApiRequest;
use App\Entity\Game;
use App\Service\API\GameSpotAdapter;
use App\Service\ApiJsonResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/game-spot")
 */
class GameSpotApiController extends BaseApiController
{
    private GameSpotAdapter $gameSpotAdapter;

    public function __construct(ApiJsonResponseBuilder $builder, GameSpotAdapter $gameSpotAdapter)
    {
        parent::__construct($builder);
        $this->gameSpotAdapter = $gameSpotAdapter;
    }

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
     * @param Game $game
     * @param ApiRequest $apiRequest
     * @return JsonResponse
     */
    public function reviews(Game $game, ApiRequest $apiRequest): JsonResponse
    {
        return $this->apiResponseBuilder->respond($this->gameSpotAdapter->get('reviews', $game, $apiRequest));
    }

    /**
     * @Route("/videos/{id}", name="game_spot_game_videos", methods={"POST"})
     * @param Game $game
     * @param ApiRequest $apiRequest
     * @return JsonResponse
     */
    public function videos(Game $game, ApiRequest $apiRequest): JsonResponse
    {
        return $this->apiResponseBuilder->respond($this->gameSpotAdapter->get('videos', $game, $apiRequest));
    }
}
