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
    public function index(
        Request $request,
        AppartmentService $appService
    )
    {
        $data = $appService->getAppartmentsByUser($this->getUser());

        return $this->render('appartment/index.html.twig', [
            'count' => count($data['data']),
            'appartments' => $data['data']
        ]);
    }

    /**
     * AJOUT D'UNE ANNONCE
     * @Route("/mon-compte/annonce/ajout", name="app_announcement_add")
     */
    public function addAnnouncement(
        Request $request,
        AppartmentService $appService
    ) {
        $appartment = new Appartment();

        $form = $this->createForm(AppartmentType::class, $appartment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $appService->pushAppartment($appartment, false);

            $this->addFlash('notice', $data['msg']);
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('appartment/announcement.html.twig', [
            'form' => $form->createView(),
            'type' => 'Ajout'
        ]);
    }

    /**
     * EDITION D'UNE ANNONCE
     * @Route("/mon-compte/annonce/edition/{id}", name="app_announcement_edit")
     */
    public function editAnnouncement(
        Request $request,
        AppartmentService $appService,
        int $id
    ) {
        $appartment = $appService->getAppartmentInfo($id);
        if(!$appartment['info']){
            $this->addFlash('notice', $appartment['data']);
            return $this->redirectToRoute('app_dashboard');
        }

        if($appartment['data']->getUser() != $this->getUser()){
            return $this->redirectToRoute('home');
        }

        $app = $appartment['data'];
        $form = $this->createForm(AppartmentType::class, $app);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $appService->pushAppartment($app, true);

            $this->addFlash('notice', $data['msg']);
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('appartment/announcement.html.twig', [
            'form' => $form->createView(),
            'type' => 'Edition'
        ]);
    }
}
