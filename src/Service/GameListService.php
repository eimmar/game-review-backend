<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Game;
use App\Entity\GameList;
use App\Entity\User;
use App\Enum\GameListPrivacyType;
use App\Enum\GameListType;
use App\Enum\LogicExceptionCode;
use App\Exception\LogicException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ExpressionBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\LazyCriteriaCollection;
use Symfony\Component\Security\Core\Security;

class GameListService
{
    private EntityManagerInterface $entityManager;

    private Security $security;

    /**
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     */
    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
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
     * @param bool $initialized
     * @throws \Exception
     */
    public function validate(GameList $gameList, bool $initialized = true)
    {
        $expr = Criteria::expr();
        $duplicateNameCriteria = Criteria::create()->where($expr->andX(
            ...array_filter([
                $expr->eq('type', GameListType::CUSTOM),
                $expr->eq('name', $gameList->getName()),
                $initialized ? $expr->neq('id', $gameList->getId()) : null
            ])
        ));

        if (
            !in_array($gameList->getType(), [GameListType::FAVORITES, GameListType::WISHLIST, GameListType::PLAYING, GameListType::CUSTOM])
            || !in_array($gameList->getPrivacyType(), [GameListPrivacyType::PRIVATE, GameListPrivacyType::FRIENDS_ONLY, GameListPrivacyType::PUBLIC])
            || $gameList->getUser()->getGameLists()->matching($duplicateNameCriteria)->count()
        ) {
            throw new LogicException(LogicExceptionCode::GAME_LIST_DUPLICATE_NAME);
        }
    }

    /**
     * @param GameList $gameList
     * @param Game $game
     */
    public function addToList(GameList $gameList, Game $game)
    {
        $gameList->addGame($game);
        $this->validate($gameList);

        $this->entityManager->persist($gameList);
        $this->entityManager->flush();
    }

    /**
     * @param GameList $gameList
     * @param Game $game
     * @return GameList
     */
    public function removeFromList(GameList $gameList, Game $game): GameList
    {
        $gameList->removeGame($game);
        $this->validate($gameList);

        $this->entityManager->persist($gameList);
        $this->entityManager->flush();

        return $gameList;
    }

    /**
     * @param User $user
     * @return GameList[]
     */
    public function getListsByUser(User $user)
    {
        return $user->getGameLists()->matching($this->privacyTypeCriteria())->toArray();
    }

    /**
     * @param User $user
     * @param Game $game
     * @return GameList[]
     */
    public function getUserListsContainingGame(User $user, Game $game)
    {
        $gameLists = $this->entityManager
            ->getRepository(GameList::class)
            ->getGameListsWithContainingInfo($game, $user);

        return array_values((new ArrayCollection($gameLists))->matching($this->privacyTypeCriteria())->toArray());
    }
}
