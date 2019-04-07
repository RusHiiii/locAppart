<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 07/04/2019
 * Time: 17:15
 */

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InformationControllerTest extends WebTestCase
{
    /**
     * TEST PAGE CONTACT
     */
    public function testContact()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contact');

        // Gestion du formualaire
        $form = $crawler->selectButton('contact_save')->form();
        $form['contact[email]'] = 'test@test.fr';
        $form['contact[type]'] = 'annonce';
        $form['contact[subject]'] = 'sujet';
        $form['contact[message]'] = 'ceci est un message de 20 caracteres';
        $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * TEST PAGE INFORMATIONS
     */
    public function testInformation()
    {
        $client = static::createClient();

        $client->request('GET', '/information');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * TEST PAGE MENTIONS
     */
    public function testMentions()
    {
        $client = static::createClient();

        $client->request('GET', '/mentions-legales');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}