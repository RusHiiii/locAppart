<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 14/04/2019
 * Time: 13:43
 */

namespace App\Tests\Controller;


use App\Entity\WebApp\User;
use App\Service\WebApp\AppartmentService;
use App\Service\WebApp\CityService;
use App\Service\WebApp\MessageService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class XhrControllerTest extends WebTestCase
{
    /**
     * AUTH DE L'USER
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function createAuthorizedClient()
    {
        $client = static::createClient();
        $container = static::$kernel->getContainer();
        $session = $container->get('session');
        $person = self::$kernel->getContainer()->get('doctrine')->getRepository(User::class)->find(1);

        $token = new UsernamePasswordToken($person, null, 'main', $person->getRoles());
        $session->set('_security_main', serialize($token));
        $session->save();

        $client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));

        return $client;
    }

    /**
     * TEST DE LA RECUPERATION DES VILLES
     */
    public function testGetCityInformation()
    {
        $client = $this->createAuthorizedClient();

        $cityService = $this->createMock(CityService::class);
        $cityService
            ->expects($this->any())
            ->method('getCityInformationLocation')
            ->willReturn([]);
        $client->getContainer()->set(CityService::class, $cityService);

        $client->xmlHttpRequest('POST', '/xhr/ville', ['city' => '5']);

        $response = $client->getResponse()->getStatusCode();
        $this->assertEquals(200, $response);
    }

    /**
     * TEST DE SUPPRESSION D'UN APPARTEMENT
     */
    public function testRemoveAppartment()
    {
        $client = $this->createAuthorizedClient();

        $appService = $this->createMock(AppartmentService::class);
        $appService
            ->expects($this->any())
            ->method('removeAppartment')
            ->willReturn([]);
        $client->getContainer()->set(AppartmentService::class, $appService);

        $client->xmlHttpRequest('POST', '/xhr/appartement/suppression', ['appartment' => '5']);

        $response = $client->getResponse()->getStatusCode();
        $this->assertEquals(200, $response);
    }

    /**
     * TEST DE SUPPRESSION DE MESSAGE
     */
    public function testRemoveMessage()
    {
        $client = $this->createAuthorizedClient();

        $msgService = $this->createMock(MessageService::class);
        $msgService
            ->expects($this->any())
            ->method('removeMessage')
            ->willReturn([]);
        $client->getContainer()->set(MessageService::class, $msgService);

        $client->xmlHttpRequest('POST', '/xhr/message/suppression', ['message' => '5']);

        $response = $client->getResponse()->getStatusCode();
        $this->assertEquals(200, $response);
    }
}