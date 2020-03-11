<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use App\Service\IGDB\ApiConnector;
use App\Service\IGDB\RequestBody;
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
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/", name="game_index", methods={"GET"})
     * @param GameRepository $gameRepository
     * @return JsonResponse
     */
    public function index(GameRepository $gameRepository, ApiConnector $connector): JsonResponse
    {
        $response = $connector->games(new RequestBody());
        return $this->apiResponseBuilder->buildResponse($response);
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
     * @Route("/{id}", name="game_show", methods={"GET"})
     * @param Game $game
     * @return JsonResponse
     */
    public function show(Game $game): JsonResponse
    {
        $game->getReviews();
        return $this->apiResponseBuilder->buildResponse($game);
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
     * @IsGranted({"ROLE_SUPER_ADMIN"})
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
