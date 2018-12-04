<?php

namespace App\DataFixtures;

use App\Entity\Appartment;
use App\Entity\Status;
use App\Entity\Type;
use App\Entity\City;
use App\Entity\User;
use App\Entity\Message;
use App\Entity\Ressource;
use App\Entity\Price;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppartmentFixtures extends Fixture
{
    private $faker;

    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $this->faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $appartment = new Appartment();
            $appartment->setTitle($this->faker->sentence(6));
            $appartment->setArea($this->faker->numberBetween(10, 300));
            $appartment->setRoom($this->faker->randomDigit);
            $appartment->setDescription($this->faker->text);
            $appartment->setGarage($this->faker->boolean);
            $appartment->setLocker($this->faker->boolean);
            $appartment->setPeople($this->faker->randomDigit);
            $appartment->setBedroom($this->faker->randomDigit);
            $appartment->setSki($this->faker->numberBetween(200, 3000));
            $appartment->setInformation(null);
            $appartment->setAdress($this->faker->streetAddress);
            $appartment->setLat($this->faker->latitude);
            $appartment->setLng($this->faker->longitude);
            $appartment->setReference($this->faker->word);
            $appartment->setDate($this->faker->datetime);
            $appartment->setStatus($this->generateStatus($manager));
            $appartment->setType($this->generateType($manager));
            $appartment->setCity($this->generateCity($manager));
            $appartment->setUser($this->generateUser($manager));
            $appartment->addMessage($this->generateMessage($manager, $appartment));
            $appartment->addRessource($this->generateRessource($manager, $appartment));
            $appartment->addPrice($this->generatePrice($manager, $appartment));

            $manager->persist($appartment);
        }

        $manager->flush();
    }

    private function generateStatus(ObjectManager $manager)
    {
        $status = new Status();
        $status->setName($this->faker->word);

        $manager->persist($status);

        return $status;
    }

    private function generateType(ObjectManager $manager)
    {
        $type = new Type();
        $type->setName($this->faker->word);

        $manager->persist($type);

        return $type;
    }

    private function generateCity(ObjectManager $manager)
    {
        $city = new City();
        $city->setName($this->faker->city);
        $city->setLat($this->faker->latitude);
        $city->setLng($this->faker->longitude);

        $manager->persist($city);

        return $city;
    }

    private function generateUser(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail($this->faker->email);
        $user->setFirstname($this->faker->firstName);
        $user->setLastname($this->faker->lastName);
        $user->setPassword($this->faker->password);
        $user->setDate($this->faker->dateTime);
        $user->setGender($this->faker->title);

        $manager->persist($user);

        return $user;
    }

    private function generateMessage(ObjectManager $manager, Appartment $appartment)
    {
        $message = new Message();
        $message->setEmail($this->faker->email);
        $message->setSubject($this->faker->word);
        $message->setPhone($this->faker->phoneNumber);
        $message->setText($this->faker->text);
        $message->setDate($this->faker->datetime);
        $message->setAppartment($appartment);

        $manager->persist($message);

        return $message;
    }

    private function generateRessource(ObjectManager $manager, Appartment $appartment)
    {
        $ressource = new Ressource();
        $ressource->setFile($this->faker->file('assets', 'assets/images'));
        $ressource->setAppartment($appartment);

        $manager->persist($ressource);

        return $ressource;
    }

    private function generatePrice(ObjectManager $manager, Appartment $appartment)
    {
        $price = new Price();
        $price->setDateBegin($this->faker->datetime);
        $price->setDateEnd($this->faker->datetime);
        $price->setPrice($this->faker->randomFloat);
        $price->setAvailability($this->faker->word);
        $price->setAppartment($appartment);

        $manager->persist($price);

        return $price;
    }
}
