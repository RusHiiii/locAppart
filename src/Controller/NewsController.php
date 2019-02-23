<?php

namespace App\Controller;

use App\Service\NewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    /**
     * LISTING DES NEWS
     * @Route("/news", name="app_news")
     */
    public function index(
        Request $request,
        NewsService $newsService
    )
    {
        $news = $newsService->getLastestNews(5);

        return $this->render('news/index.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * AFFICHAGE POUR LE FOOTER
     * @param Request $request
     * @param NewsService $newsService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function recentNews(
        Request $request,
        NewsService $newsService
    )
    {
        $news = $newsService->getLastestNews(3);

        return $this->render('news/elements/news-footer.html.twig', [
            'news' => $news,
        ]);
    }
}
