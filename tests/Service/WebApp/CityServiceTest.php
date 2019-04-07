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
use App\Repository\WebApp\CityRepository;
use App\Repository\WebApp\MessageRepository;
use App\Repository\WebApp\UserRepository;
use App\Service\Tools\NotificationService;
use App\Service\Tools\ToolService;
use App\Service\WebApp\CityService;
use App\Service\WebApp\MessageService;
use App\Service\WebApp\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class CityServiceTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp()
    {
        $this->entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * TEST DE RECUPERATION INFO VILLE
     */
    public function testGetCityInformationLocation()
    {
        // Récupération des containers
        $cityRepository = $this->getContainer()->get(CityRepository::class);

        $CityService = new CityService($cityRepository);

        $resultCity = $CityService->getCityInformationLocation(1);

        $this->assertArrayHasKey('lat', $resultCity);
        $this->assertArrayHasKey('lng', $resultCity);
        $this->assertEquals('0.00', $resultCity['lat']);
        $this->assertEquals('0.00', $resultCity['lng']);
    }

    private function getContainer()
    {
        self::bootKernel();
        $container = self::$container;

        return $container;
    }
}