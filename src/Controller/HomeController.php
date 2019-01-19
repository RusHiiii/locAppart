<?php

namespace App\Controller;

use App\Service\AppartmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * INDEX DU SITE
     * @Route("/", name="home")
     */
    public function index(
        Request $request,
        AppartmentService $appService
    ) {
        $appartments = $appService->getXLastAppartment(4);

        return $this->render('home/index.html.twig', [
            'appartments' => $appartments,
        ]);
    }
}
