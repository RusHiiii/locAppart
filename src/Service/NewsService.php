<?php

namespace App\Service;

use App\Entity\City;
use App\Repository\CityRepository;
use App\Repository\NewsRepository;

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
