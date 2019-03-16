<?php

namespace App\Service\WebApp;

use App\Entity\WebApp\City;
use App\Repository\WebApp\CityRepository;
use App\Repository\WebApp\NewsRepository;

class NewsService
{
    private $newsRepository;

    public function __construct(
        NewsRepository $newsRepo
    ) {
        $this->newsRepository = $newsRepo;
    }

    /**
     * Récupération des dernieres news
     * @return mixed
     */
    public function getLastestNews(int $limit)
    {
        $news = $this->newsRepository->findLastestNews($limit);
        return $news;
    }
}
