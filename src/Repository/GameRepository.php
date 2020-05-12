<?php

namespace App\Repository;

use App\DTO\SearchRequest;
use App\Entity\Game;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

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
    ];

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     * @param SearchRequest $request
     * @param string $alias
     * @return QueryBuilder
     */
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
            $request->getFilter('ratingCountFrom') ? $expr->gte('ratingCount', $request->getFilter('ratingCountFrom')) : null,
            $request->getFilter('ratingCountTo') ? $expr->lte('ratingCount', $request->getFilter('ratingCountTo')) : null,
            $request->getFilter('query') ? $expr->contains('name', $request->getFilter('query')) : null,
        ]);

        foreach (self::JOIN_FILTERS as $field => $entity) {
            if ($value = $request->getFilter($entity)) {
                $conditions[] = $expr->in($entity . '.slug', (array)$value);
                $query->leftJoin("$alias.$field", $entity);
            }
        }

        if (count($conditions)) {
            $query->addCriteria(Criteria::create()->where($expr->andX(...$conditions)));
        }

        return $query;
    }

    /**
     * @param SearchRequest $request
     * @return int|mixed|string
     */
    public function filter(SearchRequest $request)
    {
        $orderBy = $request->getOrderBy() ?: 'releaseDate';
        $queryBuilder = $this->filterQueryBuilder($request, 'g');

        if (strlen($request->getFilter('query')) !== 0) {
            $queryBuilder
                ->addSelect("MATCH_AGAINST (g.name, :query 'IN NATURAL MODE') AS HIDDEN score")
                ->andWhere('MATCH_AGAINST(g.name, :query) > 0.0')
                ->setParameter('query', $request->getFilter('query'))
                ->orderBy('score', 'DESC');
        }

        return $queryBuilder
            ->addSelect("CASE WHEN g.{$orderBy} IS NULL THEN 1 ELSE 0 END as HIDDEN sortIsNull")
            ->addOrderBy('sortIsNull', 'ASC')
            ->addOrderBy('g.' . $orderBy, $request->getOrder() ?: 'DESC')
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
        $queryBuilder = $this->filterQueryBuilder($request, 'g');

        if (strlen($request->getFilter('query')) !== 0) {
            $queryBuilder
                ->andWhere('MATCH_AGAINST(g.name, :query) > 0.0')
                ->setParameter('query', $request->getFilter('query'));
        }

        return (int)$queryBuilder
            ->select('COUNT(g)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param string $slug
     * @return Game|null
     */
    public function findBySlug(string $slug)
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    /**
     * @param string $slug
     * @param DateTimeImmutable $validFrom
     * @return Game|null
     */
    public function findOneRecentlyImported(string $slug, DateTimeImmutable $validFrom)
    {
        return $this->createQueryBuilder('g')
            ->where('g.slug = :slug')
            ->andWhere('g.importedAt >= :validFrom')
            ->setParameters(['slug' => $slug, 'validFrom' => $validFrom])
            ->getQuery()
            ->getOneOrNullResult();
    }
}
