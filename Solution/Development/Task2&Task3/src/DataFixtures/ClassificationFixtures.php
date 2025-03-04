<?php

namespace App\DataFixtures;

use App\Entity\Classification;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClassificationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 3; ++$i) {
            $classification = new Classification();
            $classification->setName('Class '.$i);
            $manager->persist($classification);
        }

        $manager->flush();
    }
}
