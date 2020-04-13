<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\GameList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\AbstractQuery;

/**
 * @method GameList|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameList|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameList::class);
    }

    /**
     * @param Game $game
     * @param $user
     * @return GameList[]
     */
    public function getGameListsWithContainingInfo(Game $game, $user)
    {
        return $this->createQueryBuilder('gl')
            ->where(':game MEMBER OF gl.games')
            ->addSelect("CASE WHEN :game MEMBER OF gl.games IS NULL THEN 1 ELSE 0 END as gameInList")
            ->andWhere('gl.user = :user')
            ->setParameters(['game' => $game, 'user' => $user])
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY);
    }
}
