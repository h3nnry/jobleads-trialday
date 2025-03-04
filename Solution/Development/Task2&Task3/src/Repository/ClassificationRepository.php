<?php

namespace App\Repository;

use App\Entity\Classification;
use App\Entity\ClassificationStudent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Classification>
 */
class ClassificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classification::class);
    }

    public function findAllClassesGradeAverage(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.id, c.name, avg(cs.grade)')
            ->join(ClassificationStudent::class, 'cs', Join::WITH, 'c = cs.classification')
            ->groupBy('c.id')->getQuery()->getArrayResult();
    }
}
