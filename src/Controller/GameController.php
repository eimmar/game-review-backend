<?php

namespace App\Controller;

use App\DTO\PaginationResponse;
use App\DTO\SearchRequest;
use App\Entity\Game;
use App\Form\GameType;
use App\Repository\Game\CompanyRepository;
use App\Repository\Game\GameModeRepository;
use App\Repository\Game\GenreRepository;
use App\Repository\Game\PlatformRepository;
use App\Repository\Game\ThemeRepository;
use App\Repository\GameRepository;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/game")
 */
class GameController extends BaseApiController
{
    /**
     * @Route("/", name="game_options", methods={"OPTIONS"})
     * @Route("/{id}", name="individual_game_options", methods={"OPTIONS"})
     * @Route("/entity-filter-values", name="game_entity_filter_values_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/", name="game_index", methods={"POST"})
     * @param GameRepository $repository
     * @param SearchRequest $request
     * @return JsonResponse
     */
    public function index(GameRepository $repository, SearchRequest $request): JsonResponse
    {
        $games = $repository->findBy($request->getFilters(), ['createdAt' => 'DESC'], $request->getPageSize(), $request->getFirstResult());

        return $this->apiResponseBuilder->buildPaginationResponse(
            new PaginationResponse(1, $repository->count([]), $request->getPageSize(), $games),
            ['groups' => ['game']]
        );
    }

    /**
     * @Route("/entity-filter-values", name="game_entity_filter_values", methods={"POST"})
     * @param GenreRepository $genreRepository
     * @param ThemeRepository $themeRepository
     * @param PlatformRepository $platformRepository
     * @param GameModeRepository $gameModeRepository
     * @param CompanyRepository $companyRepository
     * @return JsonResponse
     */
    public function entityFilterValues(
        GenreRepository $genreRepository,
        ThemeRepository $themeRepository,
        PlatformRepository $platformRepository,
        GameModeRepository $gameModeRepository,
        CompanyRepository $companyRepository
    ): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse(
            [
                'genres' => $genreRepository->findAll(),
                'themes' => $themeRepository->findAll(),
                'platforms' => $platformRepository->findAll(),
                'gameModes' => $gameModeRepository->findAll(),
                'companies' => $companyRepository->findAll(),
            ],
            200,
            [],
            ['groups' => ['gameLoaded']]
        );
    }
    /**
     * @Route("/{id}", name="game_show", methods={"GET"})
     * @param Game $game
     * @return JsonResponse
     */
    public function show(Game $game): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($game, 200, [], ['groups' => 'gameLoaded']);
    }

    /**
     * @Route("/", name="game_new", methods={"POST"})
     * @IsGranted({"ROLE_ADMIN"})
     * @param Request $request
     * @return JsonResponse
     */
    public function new(Request $request): JsonResponse
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($game);
            try {
                $entityManager->flush();
            } catch (Exception $e) {
                return $this->apiResponseBuilder->buildMessageResponse('Incorrect data.', 400);
            }
            return $this->apiResponseBuilder->buildResponse($game);
        }

        return $this->apiResponseBuilder->buildFormErrorResponse($form);
    }

    /**
     * @Route("/{id}", name="game_edit", methods={"PUT"})
     * @IsGranted({"ROLE_ADMIN"})
     * @param Request $request
     * @param Game $game
     * @return JsonResponse
     */
    public function edit(Request $request, Game $game): JsonResponse
    {
        $form = $this->createForm(GameType::class, $game);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
            } catch (Exception $e) {
                return $this->apiResponseBuilder->buildMessageResponse('Incorrect data.', 400);
            }
            return $this->apiResponseBuilder->buildResponse($game);
        }

        return $this->apiResponseBuilder->buildFormErrorResponse($form);
    }

    /**
     * @Route("/{id}", name="game_delete", methods={"DELETE"})
     * @IsGranted({"ROLE_ADMIN"})
     * @param Game $game
     * @return JsonResponse
     */
    public function delete(Game $game): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($game);
        $entityManager->flush();

        return $this->apiResponseBuilder->buildResponse($game);
    }
}
