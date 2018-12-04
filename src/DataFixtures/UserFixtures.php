<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture
{
    private $faker;

    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $this->faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setFirstname($this->faker->firstName);
            $user->setLastname($this->faker->lastName);
            $user->setPassword($this->faker->password);
            $user->setDate($this->faker->dateTime);
            $user->setGender($this->faker->title);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
