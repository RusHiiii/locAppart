<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 06/04/2019
 * Time: 15:19
 */

namespace App\Tests\Service\WebApp;

use App\Entity\Search\AppartmentSearch;
use App\Entity\WebApp\Appartment;
use App\Entity\WebApp\City;
use App\Entity\WebApp\Message;
use App\Entity\WebApp\Status;
use App\Entity\WebApp\Type;
use App\Entity\WebApp\User;
use App\Repository\WebApp\AppartmentRepository;
use App\Repository\WebApp\CityRepository;
use App\Repository\WebApp\MessageRepository;
use App\Repository\WebApp\StatusRepository;
use App\Repository\WebApp\UserRepository;
use App\Service\Tools\NotificationService;
use App\Service\Tools\ToolService;
use App\Service\WebApp\AppartmentService;
use App\Service\WebApp\CityService;
use App\Service\WebApp\MessageService;
use App\Service\WebApp\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class AppartmentServiceTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp()
    {
        $this->entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * TEST RECUP DES APPART
     */
    public function testGetAllAvailableAppartment()
    {
        // Récupération des containers
        $appartmentRepository = $this->getContainer()->get(AppartmentRepository::class);
        $statusRepository = $this->getContainer()->get(StatusRepository::class);
        $entityManager = $this->getContainer()->get(EntityManagerInterface::class);
        $toolService = $this->getContainer()->get(ToolService::class);
        $paginator = $this->getContainer()->get(PaginatorInterface::class);

        $AppService = new AppartmentService($appartmentRepository, $statusRepository, $entityManager, $toolService, $paginator, 'path/to/directory');
        
        $result = $AppService->getAllAvailableAppartment(0, new AppartmentSearch(), 'chalet');

        $this->assertInstanceOf(SlidingPagination::class, $result);
    }

    /**
     * TEST RECUPERATION X LAST APPART
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function testGetXLastAppartment()
    {
        // Récupération des containers
        $appartmentRepository = $this->getContainer()->get(AppartmentRepository::class);
        $statusRepository = $this->getContainer()->get(StatusRepository::class);
        $entityManager = $this->getContainer()->get(EntityManagerInterface::class);
        $toolService = $this->getContainer()->get(ToolService::class);
        $paginator = $this->getContainer()->get(PaginatorInterface::class);

        $AppService = new AppartmentService($appartmentRepository, $statusRepository, $entityManager, $toolService, $paginator, 'path/to/directory');

        $result = $AppService->getXLastAppartment(1);

        $this->assertCount(1, $result);
    }

    /**
     * TEST REMOVE APPART TRUE
     */
    public function testRemoveAppartmentTrue()
    {
        // Récupération des containers
        $appartmentRepository = $this->getContainer()->get(AppartmentRepository::class);
        $statusRepository = $this->getContainer()->get(StatusRepository::class);
        $toolService = $this->getContainer()->get(ToolService::class);
        $paginator = $this->getContainer()->get(PaginatorInterface::class);

        // Création des mocks
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())->method('flush')->willReturn(true);

        $AppService = new AppartmentService($appartmentRepository, $statusRepository, $entityManager, $toolService, $paginator, 'path/to/directory');

        $result = $AppService->removeAppartment(1);

        $this->assertArrayHasKey('delete', $result);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals('L\'annonce a été supprimé !', $result['data']);
    }

    /**
     * TEST REMOVE WRONG APPART
     */
    public function testRemoveAppartmentWrong()
    {
        // Récupération des containers
        $appartmentRepository = $this->getContainer()->get(AppartmentRepository::class);
        $statusRepository = $this->getContainer()->get(StatusRepository::class);
        $toolService = $this->getContainer()->get(ToolService::class);
        $paginator = $this->getContainer()->get(PaginatorInterface::class);

        // Création des mocks
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())->method('flush')->willReturn(true);

        $AppService = new AppartmentService($appartmentRepository, $statusRepository, $entityManager, $toolService, $paginator, 'path/to/directory');

        $result = $AppService->removeAppartment(999);

        $this->assertArrayHasKey('delete', $result);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals('Aucune données trouvé.', $result['data']);
    }

    /**
     * TEST GET APPART BY USER
     */
    public function testGetAppartmentsByUser()
    {
        // Récupération des containers
        $appartmentRepository = $this->getContainer()->get(AppartmentRepository::class);
        $statusRepository = $this->getContainer()->get(StatusRepository::class);
        $toolService = $this->getContainer()->get(ToolService::class);
        $paginator = $this->getContainer()->get(PaginatorInterface::class);

        // Création des mocks
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())->method('flush')->willReturn(true);

        $AppService = new AppartmentService($appartmentRepository, $statusRepository, $entityManager, $toolService, $paginator, 'path/to/directory');

        $result = $AppService->getAppartmentsByUser($this->entityManager->getRepository(User::class)->find(1));

        $this->assertArrayHasKey('data', $result);
        $this->assertCount(1, $result);
    }

    /**
     * TEST GET APPART INFO
     */
    public function testGetAppartmentInfo()
    {
        // Récupération des containers
        $appartmentRepository = $this->getContainer()->get(AppartmentRepository::class);
        $statusRepository = $this->getContainer()->get(StatusRepository::class);
        $toolService = $this->getContainer()->get(ToolService::class);
        $paginator = $this->getContainer()->get(PaginatorInterface::class);

        // Création des mocks
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())->method('flush')->willReturn(true);

        $AppService = new AppartmentService($appartmentRepository, $statusRepository, $entityManager, $toolService, $paginator, 'path/to/directory');

        $result = $AppService->getAppartmentInfo(1);

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('info', $result);
        $this->assertTrue($result['info']);
    }

    /**
     * TEST EDITION APPARTEMENT
     */
    public function testEditAppartment()
    {
        // Récupération des containers
        $appartmentRepository = $this->getContainer()->get(AppartmentRepository::class);
        $statusRepository = $this->getContainer()->get(StatusRepository::class);
        $toolService = $this->getContainer()->get(ToolService::class);
        $paginator = $this->getContainer()->get(PaginatorInterface::class);

        // Création des mocks
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())->method('flush')->willReturn(true);

        $AppService = new AppartmentService($appartmentRepository, $statusRepository, $entityManager, $toolService, $paginator, 'path/to/directory');

        $result = $AppService->pushAppartment($this->entityManager->getRepository(Appartment::class)->find(1), true, $this->entityManager->getRepository(User::class)->find(1));

        $this->assertArrayHasKey('msg', $result);
        $this->assertEquals('L\'annonce a été modifié !', $result['msg']);
    }

    /**
     * TEST AJOUT APPARTEMENT
     */
    public function testAddAppartment()
    {
        // Récupération des containers
        $appartmentRepository = $this->getContainer()->get(AppartmentRepository::class);
        $statusRepository = $this->getContainer()->get(StatusRepository::class);
        $toolService = $this->getContainer()->get(ToolService::class);
        $paginator = $this->getContainer()->get(PaginatorInterface::class);

        // Création des mocks
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())->method('flush')->willReturn(true);

        $AppService = new AppartmentService($appartmentRepository, $statusRepository, $entityManager, $toolService, $paginator, 'path/to/directory');

        $result = $AppService->pushAppartment($this->getAppartmentData(), false, $this->entityManager->getRepository(User::class)->find(1));

        $this->assertArrayHasKey('msg', $result);
        $this->assertEquals('L\'annonce a été ajouté ! Elle est en cours de modération.', $result['msg']);
    }

    private function getContainer()
    {
        self::bootKernel();
        $container = self::$container;

        return $container;
    }

    /**
     * RECUP DES DONNEES
     *
     * @return Appartment
     *
     * @throws \Exception
     */
    private function getAppartmentData()
    {
        $app = new Appartment();
        $app
            ->setDescription('Petit appartement')
            ->setLat('45.0')
            ->setLng('6.0')
            ->setCity($this->entityManager->getRepository(City::class)->find(1))
            ->setDate(new \DateTime('NOW'))
            ->setReference('APPCLERM090')
            ->setStatus($this->entityManager->getRepository(Status::class)->find(1))
            ->setArea('33')
            ->setRoom('2')
            ->setTitle('Appartement proche des pistes')
            ->setType($this->entityManager->getRepository(Type::class)->find(1))
            ->setAddress('centre ville');

        return $app;
    }
}