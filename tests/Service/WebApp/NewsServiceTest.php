<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 06/04/2019
 * Time: 15:19
 */

namespace App\Tests\Service\WebApp;

use App\Entity\WebApp\Appartment;
use App\Repository\WebApp\AppartmentRepository;
use App\Repository\WebApp\NewsRepository;
use App\Service\Tools\ToolService;
use App\Service\WebApp\NewsService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NewsServiceTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp()
    {
        $this->entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * TEST DES NEWS
     */
    public function testGetLastestNews()
    {
        // Récupération des containers
        $newsRepo = $this->getContainer()->get(NewsRepository::class);

        $NewsService = new NewsService($newsRepo);

        $message = $NewsService->getLastestNews(1);

        $this->assertNotEmpty($message);
    }

    private function getContainer()
    {
        self::bootKernel();
        $container = self::$container;

        return $container;
    }
}