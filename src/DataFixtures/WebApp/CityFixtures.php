<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 06/04/2019
 * Time: 15:22
 */

namespace App\DataFixtures\WebApp;


use App\Entity\WebApp\City;
use App\Entity\WebApp\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CityFixtures extends Fixture implements DependentFixtureInterface
{
    public const CITY_REFERENCE = 'city';

    public function load(ObjectManager $manager)
    {
        $city = new City();
        $city
            ->setName('Clermont')
            ->setLng('0.0')
            ->setLat('0.0')
            ->setZip('63000')
            ->setDepartment($this->getReference(DepartmentFixtures::DEPARTMENT_REFERENCE));


        $manager->persist($city);
        $manager->flush();

        $this->addReference(self::CITY_REFERENCE, $city);
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
            DepartmentFixtures::class
        );
    }
}