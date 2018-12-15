<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 15/12/2018
 * Time: 16:43
 */

namespace App\Tests\Service;

use App\Entity\User;
use App\Service\NotificationService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class NotificationServiceTest extends TestCase
{

    public function testSendEmail()
    {
        $notificationService = new NotificationService();

    }
}
