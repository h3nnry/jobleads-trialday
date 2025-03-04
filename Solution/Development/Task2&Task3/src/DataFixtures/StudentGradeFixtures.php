<?php

namespace App\DataFixtures;

use App\Entity\Classification;
use App\Entity\ClassificationStudent;
use App\Entity\Customer;
use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class StudentGradeFixtures extends Fixture
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {

    }
    public function load(ObjectManager $manager): void
    {
        $students = $this->entityManager->getRepository(Student::class)->findAll();
        $classifications = $this->entityManager->getRepository(Classification::class)->findAll();
        $faker = Factory::create();

        foreach ($students as $student) {
            foreach ($classifications as $classification) {
                $grade = new ClassificationStudent();
                $grade->setStudent($student);
                $grade->setClassification($classification);
                $grade->setGrade((string)$faker->numberBetween(0,100));
                $student->addClassificationStudent($grade);
                $classification->addClassificationStudent($grade);
                $this->entityManager->persist($grade);
                $this->entityManager->persist($student);
                $this->entityManager->persist($classification);
            }
        }

        $this->entityManager->flush();
    }
}
