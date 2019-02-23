<?php

namespace App\Controller;

use App\Service\NewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    /**
     * @Route("/news", name="app_news")
     */
    public function listNews(
        Request $request,
        NewsService $newsService
    )
    {
        $news = $newsService->getLastestNews(5);

        return $this->render('news/news.html.twig', [
            'news' => $news,
        ]);
    }

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
