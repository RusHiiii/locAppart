<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 07/04/2019
 * Time: 17:15
 */

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NewsControllerTest extends WebTestCase
{
    /**
     * TEST NEWS PAGE
     */
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/news');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}