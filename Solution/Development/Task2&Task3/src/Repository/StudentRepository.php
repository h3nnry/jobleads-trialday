<?php

namespace App\Repository;

use App\Entity\ClassificationStudent;
use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }
    public function findAllStudentsGradeAverage(): array
    {
        return $this->createQueryBuilder('s')
            ->select('s.id, s.first_name, s.last_name, avg(cs.grade)')
            ->join(ClassificationStudent::class, 'cs', Join::WITH, 's = cs.student')
            ->groupBy('s.id')->getQuery()->getArrayResult();
    }
}
