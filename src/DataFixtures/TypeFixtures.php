<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class TypeFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 3; $i++) {
            $type = new Type();
            $type->setName($this->faker->word);
            $manager->persist($type);
        }

        $manager->flush();
    }
}
