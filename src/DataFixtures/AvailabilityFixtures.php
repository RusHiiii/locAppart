<?php

namespace App\DataFixtures;

use App\Entity\Availability;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AvailabilityFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 10; $i++) {
            $availability = new Availability();
            $availability->setName($this->faker->name);
            $manager->persist($availability);
        }

        $manager->flush();
    }
}
