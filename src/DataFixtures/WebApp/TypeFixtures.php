<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 06/04/2019
 * Time: 15:22
 */

namespace App\DataFixtures\WebApp;


use App\Entity\WebApp\Region;
use App\Entity\WebApp\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    public const TYPE_REFERENCE = 'type';

    public function load(ObjectManager $manager)
    {
        $type = new Type();
        $type
            ->setName('Appartement');

        $manager->persist($type);
        $manager->flush();

        $this->addReference(self::TYPE_REFERENCE, $type);
    }
}