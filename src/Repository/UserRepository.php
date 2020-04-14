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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    private function filterQueryBuilder(SearchRequest $request, string $alias)
    {
        $queryBuilder = $this->createQueryBuilder($alias);
        if (strlen($request->filter('query')) !== 0) {
            $queryBuilder
                ->addSelect("MATCH_AGAINST (u.firstName, u.lastName, u.email, :query 'IN NATURAL MODE') AS HIDDEN score")
                ->add('where', 'MATCH_AGAINST(u.firstName, u.lastName, u.email, :query) > 0.0')
                ->setParameter('query', $request->filter('query'))
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

    public function filter(SearchRequest $request)
    {
        return $this->filterQueryBuilder($request, 'u')
            ->setFirstResult($request->getFirstResult())
            ->setMaxResults($request->getPageSize())
            ->getQuery()
            ->getResult();
    }

    public function countWithFilter(SearchRequest $request)
    {
        return count(
            $this->filterQueryBuilder($request, 'u')
                ->getQuery()
                ->getResult()
        );
    }
}
