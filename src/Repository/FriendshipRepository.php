<?php

namespace App\Repository;

use App\DTO\SearchRequest;
use App\Entity\Friendship;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Friendship|null find($id, $lockMode = null, $lockVersion = null)
 * @method Friendship|null findOneBy(array $criteria, array $orderBy = null)
 * @method Friendship[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FriendshipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Friendship::class);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param UserInterface $user
     * @param SearchRequest $request
     */
    private function buildQueryFromRequest(QueryBuilder $queryBuilder, UserInterface $user, SearchRequest $request)
    {
        if (strlen($request->getFilter('search')) !== 0) {
            $queryBuilder
                ->leftJoin('f.sender', 's')
                ->leftJoin('f.receiver', 'r')
                ->where('f.receiver = :user AND s.username LIKE :search')
                ->orWhere('f.sender = :user AND r.username LIKE :search')
                ->setParameters(['user' => $user, 'search' => "%{$request->getFilter('search')}%"]);
        } else {
            $queryBuilder
                ->where('f.receiver = :user')
                ->orWhere('f.sender = :user')
                ->setParameter('user', $user);
        }

        if ($request->getFilter('status') !== null) {
            $queryBuilder->andWhere('f.status = :status')->setParameter('status', $request->getFilter('status'));
        }
    }

    /**
     * @param UserInterface $currentUser
     * @param UserInterface $user
     * @param int|null $status
     * @return Friendship|null
     */
    public function findFriendship(UserInterface $currentUser, UserInterface $user, ?int $status = null)
    {
        $queryBuilder = $this->createQueryBuilder('f')
            ->where('f.sender = :current AND f.receiver = :user')
            ->orWhere('f.sender = :user AND f.receiver = :current')
            ->setParameters(['current' => $currentUser, 'user' => $user]);

        if ($status !== null) {
            $queryBuilder->andWhere('f.status = :status')->setParameter('status', $status);
        }

        return $queryBuilder
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param UserInterface $currentUser
     * @param UserInterface $user
     * @return Friendship|null
     */
    public function findFriendRequest(UserInterface $currentUser, UserInterface $user)
    {
       return $this->createQueryBuilder('f')
            ->where('f.sender = :user AND f.receiver = :current')
            ->setParameters(['current' => $currentUser, 'user' => $user])
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param UserInterface $user
     * @param SearchRequest $request
     * @return Friendship[]
     */
    public function findAllFriendships(UserInterface $user, SearchRequest $request)
    {
        $queryBuilder = $this->createQueryBuilder('f');
        $this->buildQueryFromRequest($queryBuilder, $user, $request);

        return $queryBuilder
            ->orderBy('f.status', 'asc')
            ->addOrderBy('f.acceptedAt', 'desc')
            ->addOrderBy('f.createdAt', 'desc')
            ->setFirstResult($request->getFirstResult())
            ->setMaxResults($request->getPageSize())
            ->getQuery()->getResult();
    }

    /**
     * @param UserInterface $user
     * @param SearchRequest $request
     * @return int
     */
    public function countFriendships(UserInterface $user, SearchRequest $request)
    {
        $queryBuilder = $this->createQueryBuilder('f')->select('COUNT(f.receiver)');
        $this->buildQueryFromRequest($queryBuilder, $user, $request);

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }
}
