<?php

namespace App\Repository;

use App\Entity\ReviewReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\AbstractQuery;

/**
 * @method ReviewReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReviewReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReviewReport[]    findAll()
 * @method ReviewReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReviewReport::class);
    }

    /**
     * @return ReviewReport[]|ArrayCollection
     */
    public function findAllForApi()
    {
        return $this->createQueryBuilder('r')
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY);
    }
}
