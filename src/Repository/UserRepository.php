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
     * @param string $alias
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function filterQueryBuilder(SearchRequest $request, string $alias)
    {
        $queryBuilder = $this->createQueryBuilder($alias);
        if (strlen($request->getFilter('query')) !== 0) {
            $queryBuilder
                ->addSelect("MATCH_AGAINST (u.firstName, u.lastName, u.email, :query 'IN NATURAL MODE') AS HIDDEN score")
                ->add('where', 'MATCH_AGAINST(u.firstName, u.lastName, u.email, :query) > 0.0')
                ->setParameter('query', $request->getFilter('query'))
                ->orderBy('score', 'DESC');
        } else {
            $orderBy = $request->getOrderBy() ?: 'createdAt';
            $queryBuilder
                ->addSelect("CASE WHEN u.{$orderBy} IS NULL THEN 1 ELSE 0 END AS HIDDEN sortIsNull")
                ->orderBy('u.' . $orderBy, $request->getOrder() ?: 'DESC')
                ->addOrderBy('sortIsNull', 'ASC');
        }

        return $queryBuilder;
    }

    /**
     * @param SearchRequest $request
     * @return int|mixed|string
     */
    public function filter(SearchRequest $request)
    {
        return $this->filterQueryBuilder($request, 'u')
            ->setFirstResult($request->getFirstResult())
            ->setMaxResults($request->getPageSize())
            ->getQuery()
            ->getResult();
    }

    /**
     * @param SearchRequest $request
     * @return int
     */
    public function countWithFilter(SearchRequest $request)
    {
        $queryBuilder = $this->createQueryBuilder('u');
        if (strlen($request->getFilter('query')) !== 0) {
            $queryBuilder
                ->add('where', 'MATCH_AGAINST(u.firstName, u.lastName, u.email, :query) > 0.0')
                ->setParameter('query', $request->getFilter('query'));
        }

        return (int)$queryBuilder
                ->getQuery()
                ->getScalarResult();
    }
}
