<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\PaginationRequest;
use App\Eimmar\IGDBBundle\DTO\Request\RequestBody;
use App\Service\API\IGDBGameAdapter;
use App\Service\API\IGDBReviewAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/igdb")
 */
class IGDBController extends BaseApiController
{
    /**
     * @Route("/reviews/{externalGameId}", name="igdb_game_reviews_options", methods={"OPTIONS"})
     * @Route("/games", name="igdb_games_options", methods={"OPTIONS"})
     * @Route("/game/{slug}", name="igdb_game_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/reviews/{externalGameId}", name="igdb_game_reviews", methods={"POST"})
     * @param IGDBReviewAdapter $reviewAdapter
     * @param int $externalGameId
     * @param PaginationRequest $paginationRequest
     * @return JsonResponse
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function reviews(IGDBReviewAdapter $reviewAdapter, int $externalGameId, PaginationRequest $paginationRequest): JsonResponse
    {
        return $this->apiResponseBuilder->respond($reviewAdapter->getReviews($externalGameId, $paginationRequest));
    }

    /**
     * @Route("/games", name="igdb_games", methods={"POST"})
     * @param IGDBGameAdapter $gameAdapter
     * @param RequestBody $requestBody
     * @return JsonResponse
     */
    public function games(IGDBGameAdapter $gameAdapter, RequestBody $requestBody): JsonResponse
    {
        return $this->apiResponseBuilder->respond($gameAdapter->findAll($requestBody), 200, [], ['groups' => ['game']]);
    }

    /**
     * @Route("/game/{slug}", name="igdb_game", methods={"POST"})
     * @param IGDBGameAdapter $gameAdapter
     * @param string $slug
     * @return JsonResponse
     */
    public function game(IGDBGameAdapter $gameAdapter, string $slug): JsonResponse
    {
        $game = $gameAdapter->findOneBySlug($slug);
        if (!$game) {
            return $this->apiResponseBuilder->respond('', 404);
        }

        return $this->apiResponseBuilder->respond($game, 200, [], ['groups' => ['game', 'gameLoaded']]);
    }
}
