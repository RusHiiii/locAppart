<?php

namespace App\Controller;

use App\Entity\Appartment;
use App\Entity\City;
use App\Entity\Status;
use App\Form\AppartmentType;
use App\Service\AppartmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AppartmentController extends AbstractController
{
    /**
     * @Route("/account/dashboard", name="app_dashboard")
     */
    public function index()
    {
        return $this->render('appartment/index.html.twig', [
            'controller_name' => 'AppartmentController',
        ]);
    }

    /**
     * @Route("/account/appartment/add", name="app_announcement")
     */
    public function addAnnouncement(
        Request $request,
        AppartmentService $appService
    )
    {
        $appartment = new Appartment();

        $form = $this->createForm(AppartmentType::class, $appartment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $appService->pushAppartment($appartment, false);
        }

        return $this->render('appartment/add_announcement.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
