<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 07/04/2019
 * Time: 17:15
 */

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    /**
     * TEST HOME PAGE
     */
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}