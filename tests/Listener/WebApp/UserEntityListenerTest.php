<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 14/04/2019
 * Time: 14:39
 */

namespace App\Tests\Listener\WebApp;


use App\Entity\WebApp\User;
use App\EventListener\WebApp\UserEntityListener;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserEntityListenerTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp()
    {
        $this->entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * TEST DU PRE-PERSIST
     *
     * @throws \Exception
     */
    public function testPrePersist()
    {
        // Récupération des containers
        $userPasswdEncoder = $this->getContainer()->get(UserPasswordEncoderInterface::class);

        // Création des mocks
        $event = $this->createMock(LifecycleEventArgs::class);
        $event->expects($this->any())->method('getEntity')->willReturn($this->entityManager->getRepository(User::class)->find(1));

        $UserListener = new UserEntityListener($userPasswdEncoder);

        $result = $UserListener->prePersist($event);

        $this->assertTrue($result);
    }

    private function getContainer()
    {
        self::bootKernel();
        $container = self::$container;

        return $container;
    }
}