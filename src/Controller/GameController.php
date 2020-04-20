<?php

namespace App\Controller;

use App\DTO\PaginationRequest;
use App\DTO\PaginationResponse;
use App\DTO\SearchRequest;
use App\Entity\GameList;
use App\Repository\Game\GameModeRepository;
use App\Repository\Game\GenreRepository;
use App\Repository\Game\PlatformRepository;
use App\Repository\Game\ThemeRepository;
use App\Repository\GameRepository;
use App\Service\ApiJsonResponseBuilder;
use Doctrine\Common\Collections\Criteria;
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
     * @Route("/entity-filter-values", name="game_entity_filter_values_options", methods={"OPTIONS"})
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
     * @return JsonResponse
     */
    public function listGames(PaginationRequest $request, GameList $gameList): JsonResponse
    {
        $criteria = Criteria::create()
            ->orderBy(['createdAt' => 'DESC'])
            ->setFirstResult($request->getFirstResult())
            ->setMaxResults($request->getPageSize());
        $games = $gameList->getGames()->matching($criteria)->toArray();

        return $this->apiResponseBuilder->respondWithPagination(
            new PaginationResponse($request->getPage(), $gameList->getGames()->count(), $request->getPageSize(), $games),
            ['groups' => ['game']]
        );
    }

    /**
     * @Route("/entity-filter-values", name="game_entity_filter_values", methods={"POST"})
     * @param GenreRepository $genreRepository
     * @param ThemeRepository $themeRepository
     * @param PlatformRepository $platformRepository
     * @param GameModeRepository $gameModeRepository
     * @return JsonResponse
     */
    public function entityFilterValues(
        GenreRepository $genreRepository,
        ThemeRepository $themeRepository,
        PlatformRepository $platformRepository,
        GameModeRepository $gameModeRepository
    ): JsonResponse
    {
        return $this->apiResponseBuilder->respond(
            [
                'genres' => $genreRepository->findAll(),
                'themes' => $themeRepository->findAll(),
                'platforms' => $platformRepository->findAll(),
                'gameModes' => $gameModeRepository->findAll(),
            ],
            200,
            [],
            ['groups' => ['gameLoaded']]
        );
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
