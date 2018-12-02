<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $city = new City();
            $city->setName($faker->city);
            $city->setLat($faker->latitude);
            $city->setLng($faker->longitude);
            $manager->persist($city);
        }

        $manager->flush();
    }
}
