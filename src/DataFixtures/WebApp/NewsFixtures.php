<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 06/04/2019
 * Time: 15:22
 */

namespace App\DataFixtures\WebApp;


use App\Entity\WebApp\News;
use App\Entity\WebApp\Region;
use App\Entity\WebApp\Type;
use App\Entity\WebApp\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class NewsFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $news = new News();
        $news
            ->setTitle('News')
            ->setDescription('description')
            ->setCreated(new \DateTime('NOW'));

        $manager->persist($news);
        $manager->flush();
    }
}