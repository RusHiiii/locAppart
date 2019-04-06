<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 06/04/2019
 * Time: 15:19
 */

namespace App\Tests\Service\Tools;

use App\Entity\WebApp\Appartment;
use App\Repository\WebApp\AppartmentRepository;
use App\Repository\WebApp\UserRepository;
use App\Service\Tools\InformationService;
use App\Service\Tools\NotificationService;
use App\Service\Tools\ToolService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InformationServiceTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp()
    {
        $this->entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * TEST ENVOIE DU MESSAGE DE CONTACT
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testSendContactMessage()
    {
        // Récupération des containers
        $notificationService = $this->getContainer()->get(NotificationService::class);
        $userRepository = $this->getContainer()->get(UserRepository::class);

        // Création des mocks
        $templating = $this->createMock(\Twig_Environment::class);
        $templating->expects($this->any())->method('render')->willReturn(true);

        $InforationService = new InformationService($notificationService, $userRepository, $templating);

        $data = $InforationService->sendContactMessage(['messages']);

        $this->assertArrayHasKey('msg', $data);
        $this->assertEquals('Message envoyé !', $data['msg']);
    }

    private function getContainer()
    {
        self::bootKernel();
        $container = self::$container;

        return $container;
    }
}