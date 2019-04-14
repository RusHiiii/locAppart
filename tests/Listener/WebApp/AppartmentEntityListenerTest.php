<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 14/04/2019
 * Time: 14:48
 */

namespace App\Tests\Listener\WebApp;


use App\Entity\WebApp\Appartment;
use App\EventListener\WebApp\AppartmentEntityListener;
use App\Service\Tools\FileUploaderService;
use App\Service\Tools\NotificationService;
use App\Service\Tools\ToolService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\UnitOfWork;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AppartmentEntityListenerTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp()
    {
        $this->entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * TEST DU PERSIST
     *
     * @throws \Exception
     */
    public function testPrePersist()
    {
        // Récupération des containers
        $fileUploadService = $this->getContainer()->get(FileUploaderService::class);
        $toolService = $this->getContainer()->get(ToolService::class);
        $notificationService = $this->getContainer()->get(NotificationService::class);
        $templating = $this->getContainer()->get(\Twig_Environment::class);

        // Création des mocks
        $event = $this->createMock(LifecycleEventArgs::class);
        $event->expects($this->any())->method('getEntity')->willReturn($this->entityManager->getRepository(Appartment::class)->find(1));

        $AppartmentListener = new AppartmentEntityListener($fileUploadService, $toolService, $notificationService, $templating);

        $result = $AppartmentListener->prePersist($event);

        $this->assertTrue($result);
    }

    private function getContainer()
    {
        self::bootKernel();
        $container = self::$container;

        return $container;
    }
}