<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 3; $i++) {
            $type = new Type();
            $type->setName($faker->word);
            $manager->persist($type);
        }

        $manager->flush();
    }
}
