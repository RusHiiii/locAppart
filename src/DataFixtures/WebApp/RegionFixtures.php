<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 06/04/2019
 * Time: 15:22
 */

namespace App\DataFixtures\WebApp;


use App\Entity\WebApp\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RegionFixtures extends Fixture
{
    public const REGION_REFERENCE = 'region';

    public function load(ObjectManager $manager)
    {
        $region = new Region();
        $region
            ->setName('Auvergne');

        $manager->persist($region);
        $manager->flush();

        $this->addReference(self::REGION_REFERENCE, $region);
    }
}