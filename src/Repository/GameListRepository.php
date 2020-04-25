<?php

namespace App\Repository;

use App\Entity\GameList;
use App\Entity\User;
use App\Enum\GameListPrivacyType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

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
     * @param User $user
     * @param bool $includeFriendLists
     * @return GameList[]
     */
   public function findAllVisible(User $user, bool $includeFriendLists = false)
   {
       $queryBuilder = $this->createQueryBuilder('gl')
           ->where('gl.user = :user')
           ->setParameter('user', $user);

       if ($includeFriendLists) {
           $queryBuilder
               ->andWhere('gl.privacyType IN (:types)')
               ->setParameter('types', [GameListPrivacyType::PUBLIC, GameListPrivacyType::FRIENDS_ONLY]);
       } else {
           $queryBuilder
               ->andWhere('gl.privacyType = :type')
               ->setParameter('type', GameListPrivacyType::PUBLIC);
       }

       return $queryBuilder->getQuery()->getResult();
   }
}
