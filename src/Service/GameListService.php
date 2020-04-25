<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\PaginationRequest;
use App\Entity\Game;
use App\Entity\GameList;
use App\Entity\GameListGame;
use App\Entity\User;
use App\Enum\FriendshipStatus;
use App\Enum\GameListPrivacyType;
use App\Enum\LogicExceptionCode;
use App\Exception\LogicException;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ExpressionBuilder;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class GameListService
{
    private EntityManagerInterface $entityManager;

    private Security $security;

    private FriendshipService $friendshipService;

    /**
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     * @param FriendshipService $friendshipService
     */
    public function __construct(EntityManagerInterface $entityManager, Security $security, FriendshipService $friendshipService)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->friendshipService = $friendshipService;
    }

    /**
     * @param ExpressionBuilder[] $filterExpressions
     * @return Criteria
     */
    private function privacyTypeCriteria(array $filterExpressions = [])
    {
        $user = $this->security->getUser();
        $expr = Criteria::expr();
        $criteria = Criteria::create()
            ->where($expr->andX(
                $expr->eq('privacyType', GameListPrivacyType::PUBLIC),
                ...$filterExpressions
            ))
        ->orderBy(['updatedAt' => 'DESC']);

        if ($user) {
            $criteria->orWhere($expr->andX(
                $expr->in('privacyType', [GameListPrivacyType::PRIVATE, GameListPrivacyType::FRIENDS_ONLY]),
                $expr->eq('user', $user)
            ));
        }

        return $criteria;
    }

    /**
     * @param GameList $gameList
     * @param Game[] $games
     * @throws LogicException
     */
    public function createList(GameList $gameList, $games)
    {
        foreach ($games as $game) {
            $this->entityManager->persist(new GameListGame($gameList, $game));
        }
        $this->entityManager->persist($gameList);

        try {
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new LogicException(LogicExceptionCode::GAME_LIST_DUPLICATE_NAME);
        }
    }

    /**
     * @param GameList $gameList
     * @param Game $game
     */
    public function addToList(GameList $gameList, Game $game)
    {
        $this->entityManager->persist(new GameListGame($gameList, $game));
        $this->entityManager->flush();
    }

    /**
     * @param GameList $gameList
     * @param Game $game
     */
    public function removeFromList(GameList $gameList, Game $game)
    {
        /** @var GameListGame|null $gameListGame */
        $gameListGame = $this->entityManager
            ->getRepository(GameListGame::class)
            ->findOneBy(['gameList' => $gameList, 'game' => $game]);

        if ($gameListGame) {
            $this->entityManager->remove($gameListGame);
            $this->entityManager->flush();
        }
    }

    /**
     * @param User $user
     * @return GameList[]
     */
    public function getUserGameLists(User $user)
    {
        $currentUser = $this->security->getUser();
        if ($currentUser === $user) {
            return $user->getGameLists();
        }

        $isFriend = $currentUser && (bool)$this->friendshipService->getFriendship($user, FriendshipStatus::ACCEPTED);

        return $this->entityManager->getRepository(GameList::class)->findAllVisible($user, $isFriend);
    }

    /**
     * @param User $user
     * @param Game $game
     * @return GameList[]
     */
    public function getUserListsContainingGame(User $user, Game $game)
    {
        $gameListGames = $this->entityManager
            ->getRepository(GameListGame::class)
            ->getVisibleUserGameListsContainingGame($game, $user, $this->security->getUser());

        return array_map(function (GameListGame $listGame) {
            return $listGame->getGameList();
        }, $gameListGames);
    }

    /**
     * @param GameList $gameList
     * @param PaginationRequest $request
     * @return array
     */
    public function getGames(GameList $gameList, PaginationRequest $request)
    {
        $criteria = Criteria::create()
            ->orderBy(['createdAt' => 'DESC'])
            ->setFirstResult($request->getFirstResult())
            ->setMaxResults($request->getPageSize());
        return $gameList->getGameListGames()->matching($criteria)->map(function (GameListGame $listGame) {
            return $listGame->getGame();
        })->toArray();
    }
}
