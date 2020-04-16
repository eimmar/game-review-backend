<?php

namespace App\Controller;

use App\Entity\GameList;
use App\Entity\Game;
use App\Entity\User;
use App\Enum\GameListType;
use App\Form\GameListCreateType;
use App\Form\GameListUpdateType;
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
     * @Route("/new", name="gameList_new_options", methods={"OPTIONS"})
     * @Route("/{id}", name="individual_gameList_options", methods={"OPTIONS"})
     * @Route("/{id}/add/{game}", name="game_gameList_add_options", methods={"OPTIONS"})
     * @Route("/{id}/remove/{game}", name="game_gameList_remove_options", methods={"OPTIONS"})
     * @Route("/containing/game/{game}/user/{user}", name="user_lists_containing_game_options", methods={"OPTIONS"})
     * @Route("/user/{user}", name="gameLists_by_user_options", methods={"OPTIONS"})
     * @Route("/edit/{id}", name="gameList_edit_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/user/{user}", name="gameLists_by_user", methods={"GET"})
     * @param User $user
     * @param GameListService $service
     * @return JsonResponse
     */
    public function allForUser(User $user, GameListService $service): JsonResponse
    {
        $gameLists = $service->getListsByUser($user);
        return $this->apiResponseBuilder->buildResponse($gameLists, 200, [], ['groups' => 'gameList']);
    }

    /**
     * @Route("/new", name="gameList_new", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param Request $request
     * @param GameListService $service
     * @return JsonResponse
     * @throws \Exception
     */
    public function new(Request $request, GameListService $service): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $gameList = new GameList(GameListType::CUSTOM, $user);
        $form = $this->createForm(GameListCreateType::class, $gameList);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $service->validate($form->getData(), false);

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
     * @Route("/edit/{id}", name="gameList_edit", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param Request $request
     * @param GameList $gameList
     * @param GameListService $service
     * @return JsonResponse
     * @throws \Exception
     */
    public function edit(Request $request, GameList $gameList,  GameListService $service): JsonResponse
    {
        $this->denyAccessUnlessGranted(GameListVoter::UPDATE, $gameList);
        $form = $this->createForm(GameListUpdateType::class, $gameList);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $service->validate($form->getData());
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
     * @Route("/containing/game/{game}/user/{user}", name="user_lists_containing_game", methods={"GET"})
     * @param Game $game
     * @param User $user
     * @param GameListService $service
     * @return JsonResponse
     */
    public function listsContainingGame(Game $game, User $user, GameListService $service): JsonResponse
    {
        $gameLists = $service->getUserListsContainingGame($user, $game);

        return $this->apiResponseBuilder->buildResponse($gameLists, 200, [], ['groups' => 'gameList']);
    }

    /**
     * @Route("/{id}/add/{game}", name="gameList_add_game", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param GameList $gameList
     * @param Game $game
     * @param GameListService $service
     * @return JsonResponse
     */
    public function addGameToCustom(GameList $gameList, Game $game, GameListService $service): JsonResponse
    {
        $this->denyAccessUnlessGranted(GameListVoter::UPDATE, $gameList);
        $service->addToList($gameList, $game);

        return $this->apiResponseBuilder->buildResponse($gameList, 200, [], ['groups' => 'gameList']);
    }

    /**
     * @Route("/{id}/remove/{game}", name="gameList_remove_game", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param GameList $gameList
     * @param Game $game
     * @param GameListService $service
     * @return JsonResponse
     */
    public function removeGame(GameList $gameList, Game $game, GameListService $service): JsonResponse
    {
        $this->denyAccessUnlessGranted(GameListVoter::UPDATE, $gameList);
        $service->removeFromList($gameList, $game);

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

        return $this->apiResponseBuilder->buildResponse('OK');
    }
}
