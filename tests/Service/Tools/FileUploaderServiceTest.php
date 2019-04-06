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
use App\Service\Tools\FileUploaderService;
use App\Service\Tools\InformationService;
use App\Service\Tools\NotificationService;
use App\Service\Tools\ToolService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderServiceTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp()
    {
        $this->entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * VERIFICATION DE L'UPLOAD
     */
    public function testUpload()
    {
        $FileService = new FileUploaderService('path/to/directory');

        $photo = new UploadedFile('public/ressources/images/static/not-found.png', 'photo.jpg', 'image/jpeg', 123);

        $result = $FileService->upload($photo);

        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('upload', $result);
        $this->assertFalse($result['upload']);
    }

    private function getContainer()
    {
        self::bootKernel();
        $container = self::$container;

        return $container;
    }
}