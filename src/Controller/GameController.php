<?php

namespace App\Controller;

use App\DTO\PaginationRequest;
use App\DTO\PaginationResponse;
use App\DTO\SearchRequest;
use App\Entity\GameList;
use App\Repository\GameRepository;
use App\Security\Voter\GameListVoter;
use App\Service\ApiJsonResponseBuilder;
use App\Service\GameListService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/game")
 */
class GameController extends BaseApiController
{
    private GameRepository $repository;

    /**
     * @param ApiJsonResponseBuilder $builder
     * @param GameRepository $repository
     */
    public function __construct(ApiJsonResponseBuilder $builder, GameRepository $repository)
    {
        parent::__construct($builder);
        $this->repository = $repository;
    }

    /**
     * @Route("/", name="game_options", methods={"OPTIONS"})
     * @Route("/{slug}", name="individual_game_options", methods={"OPTIONS"})
     * @Route("/list/{gameList}", name="games_for_list_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/", name="game_index", methods={"POST"})
     * @param SearchRequest $request
     * @return JsonResponse
     */
    public function index(SearchRequest $request): JsonResponse
    {
        $games = $this->repository->filter($request);

        return $this->apiResponseBuilder->respondWithPagination(
            new PaginationResponse($request->getPage(), $this->repository->countWithFilter($request), $request->getPageSize(), $games),
            ['groups' => ['game']]
        );
    }

    /**
     * @Route("/list/{gameList}", name="games_for_list", methods={"POST"})
     * @param PaginationRequest $request
     * @param GameList $gameList
     * @param GameListService $service
     * @return JsonResponse
     */
    public function listGames(PaginationRequest $request, GameList $gameList, GameListService $service): JsonResponse
    {
        $this->denyAccessUnlessGranted(GameListVoter::VIEW, $gameList);
        $games = $service->getGames($gameList, $request);

        return $this->apiResponseBuilder->respond($games, 200, [], ['groups' => ['game']]);
    }

    /**
     * @Route("/{slug}", name="game_show", methods={"GET"})
     * @param string $slug
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        $game = $this->repository->findBySlug($slug);
        if (!$game) {
            return $this->apiResponseBuilder->respond('', 404);
        }

        return $this->apiResponseBuilder->respond($game, 200, [], ['groups' => 'gameLoaded']);
    }
}
