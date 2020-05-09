<?php

namespace App\Repository;

use App\DTO\SearchRequest;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param SearchRequest $request
     * @return int|mixed|string
     */
    public function filter(SearchRequest $request)
    {
        $orderBy = $request->getOrderBy() ?: 'createdAt';

        $queryBuilder = $this->createQueryBuilder('u')
            ->addSelect("CASE WHEN u.{$orderBy} IS NULL THEN 1 ELSE 0 END AS HIDDEN sortIsNull")
            ->where('u.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('u.' . $orderBy, $request->getOrder() ?: 'DESC')
            ->addOrderBy('sortIsNull', 'ASC')
            ->setFirstResult($request->getFirstResult())
            ->setMaxResults($request->getPageSize());

        if (strlen($request->getFilter('query')) !== 0) {
            $queryBuilder->andWhere('u.username LIKE :username')
                ->setParameter('username', "%{$request->getFilter('query')}%");
        }

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

    /**
     * @param SearchRequest $request
     * @return int
     */
    public function countWithFilter(SearchRequest $request)
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->where('u.enabled = :enabled')
            ->setParameter('enabled', true);

        if (strlen($request->getFilter('query')) !== 0) {
            $queryBuilder->andWhere('u.username LIKE :username')
                ->setParameter('username', $request->getFilter('query'));
        }

        return (int)$queryBuilder
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param string $username
     * @return User|null
     */
    public function findActiveUser(string $username): ?User
    {
        return $this->createQueryBuilder('u')
            ->where('u.enabled = :enabled')
            ->andWhere('u.username = :username')
            ->setParameters(['enabled' => true, 'username' => $username])
            ->getQuery()
            ->getOneOrNullResult();
    }
}
