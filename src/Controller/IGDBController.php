<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\PaginationRequest;
use App\DTO\SearchRequest;
use App\Repository\GameRepository;
use App\Service\API\IGDBGameAdapter;
use App\Service\API\IGDBReviewAdapter;
use App\Service\Transformer\SearchRequestToIGDBRequestTransformer;
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
     * @param GameRepository $repository
     * @param SearchRequest $request
     * @param SearchRequestToIGDBRequestTransformer $transformer
     * @return JsonResponse
     */
    public function games(
        IGDBGameAdapter $gameAdapter,
        GameRepository $repository,
        SearchRequest $request,
        SearchRequestToIGDBRequestTransformer $transformer
    ): JsonResponse {
        try {
            $games = $gameAdapter->findAll($transformer->transform($request));
            $status = 200;
        } catch (\Exception $e) {
            $games = $repository->filter($request);
            $status = 206;
        }

        return $this->apiResponseBuilder->respond($games, $status, [], ['groups' => ['game']]);
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
