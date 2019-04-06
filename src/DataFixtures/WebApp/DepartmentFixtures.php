<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 06/04/2019
 * Time: 15:22
 */

namespace App\DataFixtures\WebApp;


use App\Entity\WebApp\Department;
use App\Entity\WebApp\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DepartmentFixtures extends Fixture implements DependentFixtureInterface
{
    public const DEPARTMENT_REFERENCE = 'department';

    public function load(ObjectManager $manager)
    {
        $dep = new Department();
        $dep
            ->setName('Allier')
            ->setRegion($this->getReference(RegionFixtures::REGION_REFERENCE));

        $manager->persist($dep);
        $manager->flush();

        $this->addReference(self::DEPARTMENT_REFERENCE, $dep);
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
            RegionFixtures::class
        );
    }
}