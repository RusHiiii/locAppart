<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 06/04/2019
 * Time: 15:22
 */

namespace App\DataFixtures\WebApp;


use App\Entity\WebApp\Appartment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AppartmentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $app = new Appartment();
        $app
            ->setDescription('Petit appartement')
            ->setLat('45.0')
            ->setLng('6.0')
            ->setCity($this->getReference(CityFixtures::CITY_REFERENCE))
            ->setDate(new \DateTime('NOW'))
            ->setReference('APPCLERM090')
            ->setUser($this->getReference(UserFixtures::USER_REFERENCE))
            ->setStatus($this->getReference(StatusFixtures::STATUS_REFERENCE))
            ->setArea('33')
            ->setRoom('2')
            ->setTitle('Appartement proche des pistes')
            ->setType($this->getReference(TypeFixtures::TYPE_REFERENCE))
            ->setAddress('centre ville');

        $manager->persist($app);
        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return array(
            CityFixtures::class,
            StatusFixtures::class,
            TypeFixtures::class,
            UserFixtures::class
        );
    }
}