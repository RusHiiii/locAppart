<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 14/04/2019
 * Time: 14:21
 */

namespace App\Tests\Controller\Security;


use App\Entity\WebApp\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityControllerTest extends WebTestCase
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
     * TEST DU LOGIN
     */
    public function testLogin()
    {
        $client = static::createClient();

        $client->request('GET', '/connexion');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * TEST DE LA DECONNEXION
     */
    public function testLogout()
    {
        $client = $this->createAuthorizedClient();

        $client->request('GET', '/deconnexion');
        //$client->followRedirect();

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    /**
     * TEST DU MDP OUBLIE
     */
    public function testForgottenPassword()
    {
        $client = static::createClient();

        $client->request('GET', '/changement-mdp');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * TEST DU RESET DU TOKEN
     */
    public function testResetPassword()
    {
        $client = static::createClient();

        $client->request('GET', '/reset-mdp/montoken');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}