<?php

namespace App\Controller;

use App\Entity\GameList;
use App\Entity\Game;
use App\Entity\User;
use App\Enum\GameListType;
use App\Enum\LogicExceptionCode;
use App\Exception\LogicException;
use App\Form\GameListCreateType;
use App\Form\GameListUpdateType;
use App\Security\Voter\GameListVoter;
use App\Service\ApiJsonResponseBuilder;
use App\Service\GameListService;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/game-list")
 */
class GameListController extends BaseApiController
{
    private GameListService $service;

    public function __construct(ApiJsonResponseBuilder $builder, GameListService $service)
    {
        parent::__construct($builder);
        $this->service = $service;
    }

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
     * @return JsonResponse
     */
    public function allForUser(User $user): JsonResponse
    {
        $gameLists = $this->service->getUserGameLists($user);

        return $this->apiResponseBuilder->respond($gameLists, 200, [], ['groups' => 'gameList']);
    }

    /**
     * @Route("/new", name="gameList_new", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param Request $request
     * @return JsonResponse
     * @throws LogicException
     */
    public function new(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $gameList = new GameList(GameListType::CUSTOM, $user);
        $form = $this->createForm(GameListCreateType::class, $gameList);
        $form->submit(json_decode($request->getContent(), true));
        $this->denyAccessUnlessGranted(GameListVoter::UPDATE, $gameList);

        if ($form->isValid()) {
            $this->service->createList($gameList, $form->get('games')->getData());

            return $this->apiResponseBuilder->respond($gameList, 200, [], ['groups' => 'gameList']);
        }

        throw new LogicException(LogicExceptionCode::INVALID_DATA);
    }

    /**
     * @Route("/{id}", name="gameList_show", methods={"GET"})
     * @param GameList $gameList
     * @return JsonResponse
     */
    public function show(GameList $gameList): JsonResponse
    {
        $this->denyAccessUnlessGranted(GameListVoter::VIEW, $gameList);
        return $this->apiResponseBuilder->respond($gameList, 200, [], ['groups' => ['gameList', 'user']]);
    }

    /**
     * @Route("/edit/{id}", name="gameList_edit", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param Request $request
     * @param GameList $gameList
     * @return JsonResponse
     * @throws Exception
     */
    public function edit(Request $request, GameList $gameList): JsonResponse
    {
        $form = $this->createForm(GameListUpdateType::class, $gameList);
        $form->submit(json_decode($request->getContent(), true));
        $this->denyAccessUnlessGranted(GameListVoter::UPDATE, $gameList);

        if ($form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
            } /** @noinspection PhpRedundantCatchClauseInspection */ catch (UniqueConstraintViolationException $e) {
                throw new LogicException(LogicExceptionCode::GAME_LIST_DUPLICATE_NAME);
            }

            return $this->apiResponseBuilder->respond($gameList, 200, [], ['groups' => ['gameList', 'user']]);
        }

        throw new LogicException(LogicExceptionCode::INVALID_DATA);
    }

    /**
     * @Route("/containing/game/{game}/user/{user}", name="user_lists_containing_game", methods={"GET"})
     * @param Game $game
     * @param User $user
     * @return JsonResponse
     */
    public function listsContainingGame(Game $game, User $user): JsonResponse
    {
        $gameLists = $this->service->getUserListsContainingGame($user, $game);

        return $this->apiResponseBuilder->respond($gameLists, 200, [], ['groups' => 'gameList']);
    }

    /**
     * @Route("/{id}/add/{game}", name="gameList_add_game", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param GameList $gameList
     * @param Game $game
     * @return JsonResponse
     */
    public function addToList(GameList $gameList, Game $game): JsonResponse
    {
        $this->denyAccessUnlessGranted(GameListVoter::UPDATE, $gameList);
        $this->service->addToList($gameList, $game);

        return $this->apiResponseBuilder->respond($gameList, 200, [], ['groups' => 'gameList']);
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
        $this->service->removeFromList($gameList, $game);

        return $this->apiResponseBuilder->respond($gameList, 200, [], ['groups' => 'gameList']);
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

        return $this->apiResponseBuilder->respond('OK');
    }
}
