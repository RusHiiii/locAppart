<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class CityFixtures extends Fixture
{
    private $faker;

    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $this->faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $city = new City();
            $city->setName($this->faker->city);
            $city->setLat($this->faker->latitude);
            $city->setLng($this->faker->longitude);
            $manager->persist($city);
        }

        $manager->flush();
    }
}
