<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\PaginationRequest;
use App\DTO\SearchRequest;
use App\Repository\GameRepository;
use App\Service\API\IGDBGameAdapter;
use App\Service\API\IGDBReviewAdapter;
use App\Service\ApiJsonResponseBuilder;
use App\Service\Transformer\SearchRequestToIGDBRequestTransformer;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/igdb")
 */
class IGDBController extends BaseApiController
{
    private IGDBGameAdapter $gameAdapter;

    private IGDBReviewAdapter $reviewAdapter;

    private GameRepository $repository;

    public function __construct(ApiJsonResponseBuilder $builder, IGDBGameAdapter $gameAdapter, IGDBReviewAdapter $reviewAdapter, GameRepository $repository)
    {
        parent::__construct($builder);
        $this->gameAdapter = $gameAdapter;
        $this->reviewAdapter = $reviewAdapter;
        $this->repository = $repository;
    }

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
     * @param int $externalGameId
     * @param PaginationRequest $paginationRequest
     * @return JsonResponse
     */
    public function reviews(int $externalGameId, PaginationRequest $paginationRequest): JsonResponse
    {
        return $this->apiResponseBuilder->respond($this->reviewAdapter->getReviews($externalGameId, $paginationRequest));
    }

    /**
     * @Route("/games", name="igdb_games", methods={"POST"})
     * @param SearchRequest $request
     * @param SearchRequestToIGDBRequestTransformer $transformer
     * @return JsonResponse
     */
    public function games(SearchRequest $request, SearchRequestToIGDBRequestTransformer $transformer): JsonResponse {
        try {
            $games = $this->gameAdapter->findAll($transformer->transform($request));
            $status = 200;
        } catch (Exception $e) {
            $games = $this->repository->filter($request);
            $status = 206;
        }

        return $this->apiResponseBuilder->respond($games, $status, [], ['groups' => ['game']]);
    }

    /**
     * @Route("/game/{slug}", name="igdb_game", methods={"POST"})
     * @param string $slug
     * @return JsonResponse
     */
    public function game(string $slug): JsonResponse
    {
        try {
            $game = $this->gameAdapter->findOneBySlug($slug);
        } catch (Exception $e) {
            $game = $this->repository->findBySlug($slug);
        }

        if (!$game) {
            return $this->apiResponseBuilder->respond('', 404);
        }

        return $this->apiResponseBuilder->respond($game, 200, [], ['groups' => ['game', 'gameLoaded']]);
    }
}
