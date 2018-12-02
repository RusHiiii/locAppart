<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setPassword($faker->password);
            $user->setDate($faker->dateTime);
            $user->setGender($faker->title);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
