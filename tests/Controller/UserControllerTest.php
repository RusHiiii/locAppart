<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 07/04/2019
 * Time: 17:15
 */

namespace App\Tests\Controller;


use App\Entity\WebApp\User;
use App\Service\WebApp\UserService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserControllerTest extends WebTestCase
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
     * TEST PAGE PROFIL
     */
    public function testIndex()
    {
        $client = $this->createAuthorizedClient();

        $client->request('GET', '/mon-compte/profil');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * TEST PAGE PROFIL
     */
    public function testRegister()
    {
        $client = static::createClient();;

        $client->request('GET', '/inscription');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}