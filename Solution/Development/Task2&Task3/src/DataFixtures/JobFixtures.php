<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class JobFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 100; ++$i) {
            $job = new Job();
            $job->setName($faker->name());
            $job->setCompany($faker->company());
            $job->setDescription($faker->text);
            $manager->persist($job);
        }

        $manager->flush();
    }
}
