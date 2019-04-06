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
use App\Service\Tools\ToolService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ToolServiceTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp()
    {
        $this->entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * GENERATION DE LA REFERENCE
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function testGenerateReference()
    {
        // Récupération des containers
        $appRepo = $this->getContainer()->get(AppartmentRepository::class);

        $ToolService = new ToolService($appRepo);

        $reference = $ToolService->generateReference($this->entityManager->getRepository(Appartment::class)->find(1));

        $this->assertEquals('APPCLERM001', $reference);
    }

    private function getContainer()
    {
        self::bootKernel();
        $container = self::$container;

        return $container;
    }
}