<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 06/04/2019
 * Time: 15:19
 */

namespace App\Tests\Service\WebApp;

use App\Entity\WebApp\Appartment;
use App\Entity\WebApp\User;
use App\Repository\WebApp\AppartmentRepository;
use App\Repository\WebApp\UserRepository;
use App\Service\Tools\NotificationService;
use App\Service\Tools\ToolService;
use App\Service\WebApp\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserServiceTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp()
    {
        $this->entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * TEST DE L'INSCRIPTION
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testRegisterUser()
    {
        // Récupération des containers
        $userRepo = $this->getContainer()->get(UserRepository::class);
        $passwordEncoder = $this->getContainer()->get(UserPasswordEncoderInterface::class);
        $notificationService = $this->getContainer()->get(NotificationService::class);

        // Création des mocks
        $templating = $this->createMock(\Twig_Environment::class);
        $templating->expects($this->any())->method('render')->willReturn(true);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())->method('flush')->willReturn(true);

        $UserService = new UserService($userRepo, $passwordEncoder, $entityManager, $templating, $notificationService);

        $message = $UserService->registerUser($this->getUser());

        $this->assertArrayHasKey('msg', $message);
        $this->assertEquals('Inscription validée !', $message['msg']);
    }

    /**
     * TEST DE LA MISE A JOUR
     */
    public function testUpdateUser()
    {
        // Récupération des containers
        $userRepo = $this->getContainer()->get(UserRepository::class);
        $passwordEncoder = $this->getContainer()->get(UserPasswordEncoderInterface::class);
        $notificationService = $this->getContainer()->get(NotificationService::class);

        // Création des mocks
        $templating = $this->createMock(\Twig_Environment::class);
        $templating->expects($this->any())->method('render')->willReturn(true);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())->method('flush')->willReturn(true);

        $UserService = new UserService($userRepo, $passwordEncoder, $entityManager, $templating, $notificationService);

        $message = $UserService->updateUser($this->entityManager->getRepository(User::class)->find(1));

        $this->assertArrayHasKey('msg', $message);
        $this->assertEquals('Votre compte a été mis à jour !', $message['msg']);
    }

    /**
     * TEST DE RESET DE MDP
     *
     * @throws \Exception
     */
    public function testResetPassword()
    {
        // Récupération des containers
        $passwordEncoder = $this->getContainer()->get(UserPasswordEncoderInterface::class);
        $notificationService = $this->getContainer()->get(NotificationService::class);

        // Création des mocks
        $templating = $this->createMock(\Twig_Environment::class);
        $templating->expects($this->any())->method('render')->willReturn(true);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())->method('flush')->willReturn(true);

        $userRepo = $this->createMock(UserRepository::class);
        $userRepo->expects($this->any())->method('findByKeyValue')->willReturn($this->getUser());

        $UserService = new UserService($userRepo, $passwordEncoder, $entityManager, $templating, $notificationService);

        $message = $UserService->resetPassword('montoken', 'password');

        $this->assertArrayHasKey('msg', $message);
        $this->assertEquals('Mot de passe mis à jour', $message['msg']);
    }

    /**
     * TEST DE MAJ DU MOT DE PASSE
     *
     * @throws \Exception
     */
    public function testUpdatePassword()
    {
        // Récupération des containers
        $passwordEncoder = $this->getContainer()->get(UserPasswordEncoderInterface::class);
        $notificationService = $this->getContainer()->get(NotificationService::class);

        // Création des mocks
        $templating = $this->createMock(\Twig_Environment::class);
        $templating->expects($this->any())->method('render')->willReturn(true);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())->method('flush')->willReturn(true);

        $userRepo = $this->createMock(UserRepository::class);
        $userRepo->expects($this->any())->method('findByKeyValue')->willReturn($this->getUser());

        $UserService = new UserService($userRepo, $passwordEncoder, $entityManager, $templating, $notificationService);
        
        $message = $UserService->updatePassword($this->getUser(), 'newPassword');

        $this->assertArrayHasKey('msg', $message);
        $this->assertEquals('Mot de passe mis à jour', $message['msg']);
    }

    /**
     * TEST DE OUBLIE DU MDP
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testForgotPassword()
    {
        // Récupération des containers
        $passwordEncoder = $this->getContainer()->get(UserPasswordEncoderInterface::class);

        // Création des mocks
        $templating = $this->createMock(\Twig_Environment::class);
        $templating->expects($this->any())->method('render')->willReturn(true);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())->method('flush')->willReturn(true);

        $userRepo = $this->createMock(UserRepository::class);
        $userRepo->expects($this->any())->method('findByKeyValue')->willReturn($this->getUser());

        $notificationService = $this->createMock(NotificationService::class);
        $notificationService->expects($this->any())->method('generateToken')->willReturn($this->getNotification());
        $notificationService->expects($this->any())->method('sendEmail')->willReturn(['msg' => 'Email envoyé !']);

        $UserService = new UserService($userRepo, $passwordEncoder, $entityManager, $templating, $notificationService);

        $message = $UserService->forgotPassword('fake@mail.com');

        $this->assertArrayHasKey('msg', $message);
        $this->assertEquals('Email envoyé !', $message['msg']);
    }

    private function getContainer()
    {
        self::bootKernel();
        $container = self::$container;

        return $container;
    }

    /**
     * RECUPERATION DES DONNEES
     *
     * @return User
     * @throws \Exception
     */
    private function getUser()
    {
        $user = new User();
        $user
            ->setEmail('test@test.test')
            ->setNotification(true)
            ->setFirstname('test')
            ->setLastname('test')
            ->setDate(new \DateTime('NOW'))
            ->setPassword('test');

        return $user;
    }

    /**
     * RECUPERATION DES NOTIF
     *
     * @return array
     * @throws \Exception
     */
    private function getNotification()
    {
        return array(
            'token' => true,
            'msg' => 'message',
            'user' => $this->getUser()
        );
    }
}