<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 06/04/2019
 * Time: 15:19
 */

namespace App\Tests\Service\Tools;

use App\Entity\WebApp\Appartment;
use App\Entity\WebApp\User;
use App\Repository\WebApp\AppartmentRepository;
use App\Repository\WebApp\UserRepository;
use App\Service\Tools\NotificationService;
use App\Service\Tools\ToolService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class NotificationServiceTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp()
    {
        $this->entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * VERIFICATION DU MAILER
     */
    public function testSendEmail()
    {
        // Récupération des containers
        $userRepo = $this->getContainer()->get(UserRepository::class);
        $passwordEncoder = $this->getContainer()->get(UserPasswordEncoderInterface::class);
        $entityManager = $this->getContainer()->get(EntityManagerInterface::class);
        $mailer = $this->getContainer()->get(\Swift_Mailer::class);
        $tokenGenerator = $this->getContainer()->get(TokenGeneratorInterface::class);
        $router = $this->getContainer()->get(RouterInterface::class);
        $templating = $this->getContainer()->get(\Twig_Environment::class);

        $NotificationService = new NotificationService($userRepo, $passwordEncoder, $entityManager, $mailer, $tokenGenerator, $router, $templating);

        $send = $NotificationService->sendEmail([$this->entityManager->getRepository(User::class)->find(1)], 'TEST', 'TEST');

        $this->assertArrayHasKey('msg', $send);
        $this->assertEquals('Email envoyé !', $send['msg']);
    }

    /**
     * GENERATION DU TOKEN
     */
    public function testGenerateToken()
    {
        // Récupération des containers
        $userRepo = $this->getContainer()->get(UserRepository::class);
        $passwordEncoder = $this->getContainer()->get(UserPasswordEncoderInterface::class);
        $mailer = $this->getContainer()->get(\Swift_Mailer::class);
        $tokenGenerator = $this->getContainer()->get(TokenGeneratorInterface::class);
        $templating = $this->getContainer()->get(\Twig_Environment::class);

        // Création des mocks
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())->method('flush')->willReturn(true);

        $router = $this->createMock(RouterInterface::class);
        $router->expects($this->any())->method('generate')->willReturn('www.locappart-montagne-test.com');

        $NotificationService = new NotificationService($userRepo, $passwordEncoder, $entityManager, $mailer, $tokenGenerator, $router, $templating);

        $send = $NotificationService->generateToken('test@test.fr');

        $this->assertArrayHasKey('msg', $send);
        $this->assertArrayHasKey('token', $send);
        $this->assertArrayHasKey('user', $send);
        $this->assertTrue($send['token']);
    }

    private function getContainer()
    {
        self::bootKernel();
        $container = self::$container;

        return $container;
    }
}