<?php

namespace App\Repository;

use App\DTO\SearchRequest;
use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    const JOIN_FILTERS = [
        'genres' => 'genre',
        'themes' => 'theme',
        'platforms' => 'platform',
        'gameModes' => 'gameMode',
        'companies' => 'company'
    ];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    private function filterQueryBuilder(SearchRequest $request, string $alias)
    {
        $expr = Criteria::expr();
        $query = $this->createQueryBuilder($alias);
        $conditions = array_filter([
            $request->getFilter('category') !== null ? $expr->in('category', (array)$request->getFilter('category')) : null,
            $request->getFilter('releaseDateFrom') ? $expr->gte('releaseDate', $request->getFilter('releaseDateFrom')) : null,
            $request->getFilter('releaseDateTo') ? $expr->lte('releaseDate', $request->getFilter('releaseDateTo')) : null,
            $request->getFilter('ratingFrom') ? $expr->gte('rating', $request->getFilter('ratingFrom')) : null,
            $request->getFilter('ratingTo') ? $expr->lte('rating', $request->getFilter('ratingTo')) : null,
        ]);

        foreach (self::JOIN_FILTERS as $field => $entity) {
            if ($value = $request->getFilter($entity)) {
                $conditions[] = $expr->in($entity . '.id', (array)$value);
                $query->leftJoin("$alias.$field", $entity);
            }
        }

        if (count($conditions)) {
            $query->addCriteria(Criteria::create()->where($expr->andX(...$conditions)));
        }

        return $query;
    }

    public function filter(SearchRequest $request)
    {
        $orderBy = $request->getOrderBy() ?: 'releaseDate';

        return $this->filterQueryBuilder($request, 'g')
            ->addSelect("CASE WHEN g.{$orderBy} IS NULL THEN 1 ELSE 0 END as HIDDEN sortIsNull")
            ->orderBy('g.' . $orderBy, $request->getOrder() ?: 'DESC')
            ->addOrderBy('sortIsNull', 'ASC')
            ->setFirstResult($request->getFirstResult())
            ->setMaxResults($request->getPageSize())
            ->getQuery()
            ->getResult();
    }

    public function countWithFilter(SearchRequest $request)
    {
        return (int)$this->filterQueryBuilder($request, 'g')
            ->select('COUNT(g)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
