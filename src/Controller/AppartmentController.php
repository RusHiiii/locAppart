<?php

namespace App\Controller;

use App\Entity\Appartment;
use App\Form\AppartmentType;
use App\Service\AppartmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AppartmentController extends AbstractController
{
    /**
     * DASHBOARD DU COMPTE
     * @Route("/mon-compte/mes-annonces", name="app_dashboard")
     */
    public function index()
    {
        return $this->render('appartment/index.html.twig', [
            'controller_name' => 'AppartmentController',
        ]);
    }

    /**
     * AJOUT D'UNE ANNONCE
     * @Route("/mon-compte/annonce/ajout", name="app_announcement")
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
