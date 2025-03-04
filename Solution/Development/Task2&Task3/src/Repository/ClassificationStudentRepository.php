<?php

namespace App\Repository;

use App\Entity\ClassificationStudent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClassificationStudent>
 */
class ClassificationStudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassificationStudent::class);
    }

    public function findOverAllGradeAverage(): string
    {
        return $this->createQueryBuilder('cs')
            ->select('avg(cs.grade)')
            ->getQuery()->getSingleScalarResult();
    }
}
