<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 06/04/2019
 * Time: 15:19
 */

namespace App\Tests\Service\WebApp;

use App\Entity\WebApp\Appartment;
use App\Entity\WebApp\Message;
use App\Entity\WebApp\User;
use App\Repository\WebApp\AppartmentRepository;
use App\Repository\WebApp\MessageRepository;
use App\Repository\WebApp\UserRepository;
use App\Service\Tools\NotificationService;
use App\Service\Tools\ToolService;
use App\Service\WebApp\MessageService;
use App\Service\WebApp\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class MessageServiceTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp()
    {
        $this->entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * TEST DE RECUPERATION DES MESSAGES
     *
     * @throws \Exception
     */
    public function testGetAllMessages()
    {
        // Récupération des containers
        $appartmentRepository = $this->getContainer()->get(AppartmentRepository::class);
        $messageRepository = $this->getContainer()->get(MessageRepository::class);
        $entityManager = $this->getContainer()->get(EntityManagerInterface::class);
        $notificationService = $this->getContainer()->get(NotificationService::class);
        $templating = $this->getContainer()->get(\Twig_Environment::class);

        $MessageService = new MessageService($appartmentRepository, $messageRepository, $entityManager, $notificationService, $templating);

        $result = $MessageService->getAllMessages($this->getUser());

        $this->assertArrayHasKey('appartments', $result);
        $this->assertArrayHasKey('count', $result);
        $this->assertEquals(0, $result['count']);
    }

    /**
     * TEST DE SUPPRESSION D'UN FAUX MESSAGE
     */
    public function testRemoveMessageWrong()
    {
        // Récupération des containers
        $appartmentRepository = $this->getContainer()->get(AppartmentRepository::class);
        $messageRepository = $this->getContainer()->get(MessageRepository::class);
        $entityManager = $this->getContainer()->get(EntityManagerInterface::class);
        $notificationService = $this->getContainer()->get(NotificationService::class);
        $templating = $this->getContainer()->get(\Twig_Environment::class);

        $MessageService = new MessageService($appartmentRepository, $messageRepository, $entityManager, $notificationService, $templating);

        $result = $MessageService->removeMessage(999);

        $this->assertArrayHasKey('delete', $result);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals('Message non trouvé', $result['data']);
    }

    /**
     * TEST PUSH MESSAGE
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testPushMessage()
    {
        // Récupération des containers
        $appartmentRepository = $this->getContainer()->get(AppartmentRepository::class);
        $messageRepository = $this->getContainer()->get(MessageRepository::class);
        $notificationService = $this->getContainer()->get(NotificationService::class);
        $templating = $this->getContainer()->get(\Twig_Environment::class);

        // Création des mocks
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())->method('flush')->willReturn(true);

        $MessageService = new MessageService($appartmentRepository, $messageRepository, $entityManager, $notificationService, $templating);

        $pushResult = $MessageService->pushMessage($this->getMessage(), $this->entityManager->getRepository(Appartment::class)->find(1));

        $this->assertArrayHasKey('msg', $pushResult);
        $this->assertEquals('Message envoyé', $pushResult['msg']);
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
     * RECUPERATION DES DONNEES
     *
     * @return User
     * @throws \Exception
     */
    private function getMessage()
    {
        $message = new Message();
        $message
            ->setEmail('test@test.fr')
            ->setPhone('0303261548')
            ->setSubject('sujet')
            ->setText('test');

        return $message;
    }
}