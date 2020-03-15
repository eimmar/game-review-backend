<?php

namespace App\Controller;

use App\Entity\GameList;
use App\Entity\Game;
use App\Entity\User;
use App\Form\GameListType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/game-list")
 */
class GameListController extends BaseApiController
{
    /**
     * @Route("/{id}", name="individual_gameList_options", methods={"OPTIONS"})
     * @Route("/game/{game}", name="game_gameList_options", methods={"OPTIONS"})
     * @Route("/{id}/add/{game}", name="game_gameList_add_options", methods={"OPTIONS"})
     * @Route("/{id}/remove/{game}", name="game_gameList_remove_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/user/{user}", name="gameLists_by_user", methods={"GET"})
     * @param User $user
     * @return JsonResponse
     */
    public function showByUser(User $user): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($user->getGameLists());
    }

    /**
     * @Route("/", name="gameList_new", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param Request $request
     * @return JsonResponse
     */
    public function new(Request $request): JsonResponse
    {
        $gameList = new GameList();
        $form = $this->createForm(GameListType::class, $gameList);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gameList);
            try {
                $entityManager->flush();
            } catch (\Exception $e) {
                return $this->apiResponseBuilder->buildMessageResponse('Incorrect data.', 400);
            }
            return $this->apiResponseBuilder->buildResponse($gameList);
        }

        return $this->apiResponseBuilder->buildFormErrorResponse($form);
    }

    /**
     * @Route("/{id}", name="gameList_show", methods={"GET"})
     * @param GameList $gameList
     * @return JsonResponse
     */
    public function show(GameList $gameList): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($gameList);
    }

    /**
     * @Route("/{id}", name="gameList_edit", methods={"PUT"})
     * @IsGranted({"ROLE_USER"})
     * @param Request $request
     * @param GameList $gameList
     * @return JsonResponse
     */
    public function edit(Request $request, GameList $gameList): JsonResponse
    {
        $form = $this->createForm(GameListType::class, $gameList);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
            } catch (\Exception $e) {
                return $this->apiResponseBuilder->buildMessageResponse('Incorrect data.', 400);
            }
            return $this->apiResponseBuilder->buildResponse($gameList);
        }

        return $this->apiResponseBuilder->buildFormErrorResponse($form);
    }

    /**
     * @Route("/{id}/add/{game}", name="gameList_add_game", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param GameList $gameList
     * @param Game $game
     * @return JsonResponse
     */
    public function addGame(GameList $gameList, Game $game): JsonResponse
    {
        $gameList->addGame($game);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($gameList);
        $entityManager->flush();

        return $this->apiResponseBuilder->buildResponse($gameList);
    }

    /**
     * @Route("/{id}/remove/{game}", name="gameList_remove_game", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param GameList $gameList
     * @param Game $game
     * @return JsonResponse
     */
    public function removeGame(GameList $gameList, Game $game): JsonResponse
    {
        $gameList->removeGame($game);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($gameList);
        $entityManager->flush();

        return $this->apiResponseBuilder->buildResponse($gameList);
    }

    /**
     * @Route("/{id}", name="gameList_delete", methods={"DELETE"})
     * @IsGranted({"ROLE_USER"})
     * @param GameList $gameList
     * @return JsonResponse
     */
    public function delete(GameList $gameList): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($gameList);
        $entityManager->flush();

        return $this->apiResponseBuilder->buildResponse($gameList);
    }
}
