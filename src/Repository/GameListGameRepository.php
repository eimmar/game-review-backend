<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\GameListGame;
use App\Entity\User;
use App\Enum\GameListPrivacyType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GameListGame|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameListGame|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameListGame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameListGameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameListGame::class);
    }

    /**
     * @param Game $game
     * @param User $user
     * @param User|null $currentUser
     * @return GameListGame[]
     */
    public function getVisibleUserGameListsContainingGame(Game $game, User $user, $currentUser = null)
    {
        $queryBuilder = $this->createQueryBuilder('glg')
            ->leftJoin('glg.gameList', 'gl')
            ->where('glg.game = :game')
            ->andWhere('gl.user = :user')
            ->setParameters(['game' => $game, 'user' => $user]);

        if ($user !== $currentUser) {
            $queryBuilder
                ->andWhere('gl.privacyType = :privacyType')
                ->setParameter('privacyType', GameListPrivacyType::PUBLIC);
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
