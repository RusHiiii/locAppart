<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class StatusFixtures extends Fixture
{
    private $faker;

    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $this->faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 3; $i++) {
            $status = new Status();
            $status->setName($this->faker->word);
            $manager->persist($status);
        }

        $manager->flush();
    }
}
