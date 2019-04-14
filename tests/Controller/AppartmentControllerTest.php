<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 14/04/2019
 * Time: 14:08
 */

namespace App\Tests\Controller;


use App\Entity\WebApp\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AppartmentControllerTest extends WebTestCase
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
     * TEST DU DASHBOARD
     */
    public function testDashboard()
    {
        $client = $this->createAuthorizedClient();

        $client->xmlHttpRequest('GET', '/mon-compte/mes-annonces');

        $response = $client->getResponse()->getStatusCode();
        $this->assertEquals(200, $response);
    }

    /**
     * TEST DE L'AJOUT
     */
    public function testAddAnnouncement()
    {
        $client = $this->createAuthorizedClient();

        $client->xmlHttpRequest('GET', '/mon-compte/annonce/ajout');

        $response = $client->getResponse()->getStatusCode();
        $this->assertEquals(200, $response);
    }

    /**
     * TEST DE L'EDITION
     */
    public function testEditAnnouncement()
    {
        $client = $this->createAuthorizedClient();

        $client->xmlHttpRequest('GET', '/mon-compte/annonce/edition/5');

        $crawler = $client->followRedirect();

        $response = $client->getResponse()->getStatusCode();
        $this->assertEquals(200, $response);
        $this->assertEquals(1, $crawler->filter('html:contains("Aucune données trouvé.")')->count());
    }

    /**
     * TEST DU LISTING
     */
    public function testListing()
    {
        $client = $this->createAuthorizedClient();

        $client->xmlHttpRequest('GET', '/annonces/type/chalet');

        $response = $client->getResponse()->getStatusCode();
        $this->assertEquals(200, $response);
    }

    /**
     * TEST DU DETAIL DE L'ANNONCE
     */
    public function testShowAppartment()
    {
        $client = $this->createAuthorizedClient();

        $client->xmlHttpRequest('GET', '/annonces/slug-1');

        $response = $client->getResponse()->getStatusCode();
        $this->assertEquals(200, $response);
    }
}