<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 06/04/2019
 * Time: 15:22
 */

namespace App\DataFixtures\WebApp;


use App\Entity\WebApp\Region;
use App\Entity\WebApp\Status;
use App\Entity\WebApp\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    public const STATUS_REFERENCE = 'status';

    public function load(ObjectManager $manager)
    {
        $status = new Status();
        $status
            ->setName('Accepté')
            ->setDescription('ma description');

        $manager->persist($status);
        $manager->flush();

        $this->addReference(self::STATUS_REFERENCE, $status);
    }
}