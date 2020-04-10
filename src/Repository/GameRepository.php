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
            $request->filter('category') !== null ? $expr->in('category', (array)$request->filter('category')) : null,
            $request->filter('releaseDateFrom') ? $expr->gte('releaseDate', $request->filter('releaseDateFrom')) : null,
            $request->filter('releaseDateTo') ? $expr->lte('releaseDate', $request->filter('releaseDateTo')) : null,
            $request->filter('ratingFrom') ? $expr->gte('rating', $request->filter('ratingFrom')) : null,
            $request->filter('ratingTo') ? $expr->lte('rating', $request->filter('ratingTo')) : null,
        ]);

        foreach (self::JOIN_FILTERS as $field => $entity) {
            if ($value = $request->filter($entity)) {
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
        return $this->filterQueryBuilder($request, 'g')
            ->orderBy('g.' . $request->getOrderBy(), $request->getOrder())
            ->setFirstResult($request->getFirstResult())
            ->setMaxResults($request->getPageSize())
            ->getQuery()
            ->getResult();
    }

    public function countWithFilter(SearchRequest $request)
    {
        return $this->filterQueryBuilder($request, 'g')
            ->select('COUNT(g)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
