<?php

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Job>
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Job::class);
    }

    public function iterateOverAllJobs(int $batchCount = 1000): iterable
    {
        $offset = 0;
        do {
            /** @var Job[] $jobs */
            $jobs = $this->findBy([], null, $batchCount, $offset);

            foreach ($jobs as $job) {
                yield $job;
            }

            $offset += $batchCount;

            $this->getEntityManager()->clear();
        } while (count($jobs) > 0);
    }
}
