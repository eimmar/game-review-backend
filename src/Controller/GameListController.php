<?php

namespace App\Controller;

use App\Entity\GameList;
use App\Entity\Game;
use App\Entity\User;
use App\Form\GameListType;
use App\Security\GameListVoter;
use App\Service\GameListService;
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
     * @Route("/{id}/add/{game}", name="game_gameList_add_options", methods={"OPTIONS"})
     * @Route("/{id}/remove/{game}", name="game_gameList_remove_options", methods={"OPTIONS"})
     * @Route("/add/{type}/{game}", name="add_game_to_predefined_list_options", methods={"OPTIONS"})
     * @Route("/remove/{type}/{game}", name="remove_game_to_predefined_list_options", methods={"OPTIONS"})
     * @Route("/containing/{game}", name="lists_containing_game_options", methods={"OPTIONS"})
     * @Route("/user/{user}", name="gameLists_by_user_options", methods={"OPTIONS"})
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
    public function allForUser(User $user): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($user->getGameLists(), 200, [], ['groups' => 'gameList']);
    }

    /**
     * @Route("/", name="gameList_new", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param Request $request
     * @return JsonResponse
     */
    public function new(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $gameList = new GameList();
        $gameList->setUser($user);
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
            return $this->apiResponseBuilder->buildResponse($gameList, 200, [], ['groups' => 'gameList']);
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
        $this->denyAccessUnlessGranted(GameListVoter::VIEW, $gameList);
        return $this->apiResponseBuilder->buildResponse($gameList, 200, [], ['groups' => 'gameList']);
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
        $this->denyAccessUnlessGranted(GameListVoter::UPDATE, $gameList);

        $form = $this->createForm(GameListType::class, $gameList);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
            } catch (\Exception $e) {
                return $this->apiResponseBuilder->buildMessageResponse('Incorrect data.', 400);
            }
            return $this->apiResponseBuilder->buildResponse($gameList, 200, [], ['groups' => 'gameList']);
        }

        return $this->apiResponseBuilder->buildFormErrorResponse($form);
    }

    /**
     * @Route("/add/{type}/{game}", name="add_game_to_predefined_list", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param Game $game
     * @param int $type
     * @param GameListService $service
     * @return JsonResponse
     * @throws \Exception
     */
    public function addGameToPredefinedList(Game $game, int $type, GameListService $service): JsonResponse
    {
        $gameList = $service->getPredefinedTypeList($type);
        $this->denyAccessUnlessGranted(GameListVoter::UPDATE, $gameList);
        $service->addToList($gameList, $game);

        return $this->apiResponseBuilder->buildResponse($gameList, 200, [], ['groups' => 'gameList']);
    }


    /**
     * @Route("/remove/{type}/{game}", name="remove_game_to_predefined_list", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param Game $game
     * @param int $type
     * @param GameListService $service
     * @return JsonResponse
     * @throws \Exception
     */
    public function removeGameFromPredefinedList(Game $game, int $type, GameListService $service): JsonResponse
    {
        $gameList = $service->getPredefinedTypeList($type);
        $this->denyAccessUnlessGranted(GameListVoter::UPDATE, $gameList);
        $service->removeFromList($gameList, $game);

        return $this->apiResponseBuilder->buildResponse($gameList, 200, [], ['groups' => 'gameList']);
    }

    /**
     * @Route("/containing/{game}", name="lists_containing_game", methods={"GET"})
     * @param Game $game
     * @param GameListService $service
     * @return JsonResponse
     * @throws \Exception
     */
    public function listsContainingGame(Game $game, GameListService $service): JsonResponse
    {
        $gameLists = $service->getUserListsContaining($game);

        return $this->apiResponseBuilder->buildResponse($gameLists, 200, [], ['groups' => 'gameList']);
    }

    /**
     * @Route("/{id}/add/{game}", name="gameList_add_game", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param GameList $gameList
     * @param Game $game
     * @return JsonResponse
     */
    public function addGameToCustom(GameList $gameList, Game $game): JsonResponse
    {
        $this->denyAccessUnlessGranted(GameListVoter::UPDATE, $gameList);

        $gameList->addGame($game);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($gameList);
        $entityManager->flush();

        return $this->apiResponseBuilder->buildResponse($gameList, 200, [], ['groups' => 'gameList']);
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
        $this->denyAccessUnlessGranted(GameListVoter::UPDATE, $gameList);

        $gameList->removeGame($game);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($gameList);
        $entityManager->flush();

        return $this->apiResponseBuilder->buildResponse($gameList, 200, [], ['groups' => 'gameList']);
    }

    /**
     * @Route("/{id}", name="gameList_delete", methods={"DELETE"})
     * @IsGranted({"ROLE_USER"})
     * @param GameList $gameList
     * @return JsonResponse
     */
    public function delete(GameList $gameList): JsonResponse
    {
        $this->denyAccessUnlessGranted(GameListVoter::DELETE, $gameList);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($gameList);
        $entityManager->flush();

        return $this->apiResponseBuilder->buildResponse($gameList, 200, [], ['groups' => 'gameList']);
    }
}
