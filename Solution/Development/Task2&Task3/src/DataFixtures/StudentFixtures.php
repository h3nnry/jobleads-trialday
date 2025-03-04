<?php

namespace App\DataFixtures;

use App\Entity\Classification;
use App\Entity\Customer;
use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 100; ++$i) {
            $student = new Student();
            $student->setFirstName($faker->firstName);
            $student->setLastName($faker->lastName);

            $manager->persist($student);
        }

        $manager->flush();
    }
}
