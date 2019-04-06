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
use App\Entity\WebApp\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'user';

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setPassword('user')
            ->setDate(new \DateTime())
            ->setLastname('Damiens')
            ->setFirstname('Florent')
            ->setNotification(false)
            ->setEmail('test@test.fr');

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::USER_REFERENCE, $user);
    }
}