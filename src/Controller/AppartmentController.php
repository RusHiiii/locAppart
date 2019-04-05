<?php

namespace App\Controller;

use App\Entity\WebApp\Appartment;
use App\Entity\Search\AppartmentSearch;
use App\Entity\WebApp\Message;
use App\Form\WebApp\AppartmentType;
use App\Form\Search\AppartmentSearchType;
use App\Form\WebApp\MessageType;
use App\Service\WebApp\AppartmentService;
use App\Service\WebApp\MessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AppartmentController.
 */
class AppartmentController extends AbstractController
{
    /**
     * DASHBOARD DU COMPTE
     *
     * @Route("/mon-compte/mes-annonces", name="app_dashboard")
     */
    public function dashboard(
        Request $request,
        AppartmentService $appService
    ) {
        $data = $appService->getAppartmentsByUser($this->getUser());

        return $this->render('appartment/dashboard.html.twig', [
            'count' => count($data['data']),
            'appartments' => $data['data'],
        ]);
    }

    /**
     * AJOUT D'UNE ANNONCE.
     *
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
            'type' => 'Ajout',
        ]);
    }

    /**
     * EDITION D'UNE ANNONCE.
     *
     * @Route("/mon-compte/annonce/edition/{id}", name="app_announcement_edit")
     */
    public function editAnnouncement(
        Request $request,
        AppartmentService $appService,
        int $id
    ) {
        $appartment = $appService->getAppartmentInfo($id);
        if (!$appartment['info']) {
            $this->addFlash('notice', $appartment['data']);

            return $this->redirectToRoute('app_dashboard');
        }

        if ($appartment['data']->getUser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(AppartmentType::class, $appartment['data']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $appService->pushAppartment($appartment['data'], true);

            $this->addFlash('notice', $data['msg']);

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('appartment/announcement.html.twig', [
            'form' => $form->createView(),
            'type' => 'Edition',
        ]);
    }

    /**
     * LISTING DES ANNONCES.
     *
     * @Route("/annonces/type/{type}", name="app_announcement_listing")
     */
    public function listing(
        Request $request,
        AppartmentService $appService,
        String $type
    ) {
        $search = new AppartmentSearch();
        $formSearch = $this->createForm(AppartmentSearchType::class, $search);
        $formSearch->handleRequest($request);

        $appartments = $appService->getAllAvailableAppartment($request->query->getInt('page', 1), $search, $type);

        return $this->render('appartment/listing.html.twig', [
            'appartments' => $appartments,
            'form' => $formSearch->createView(),
            'type' => $type,
        ]);
    }

    /**
     * DETAIL D'UNE ANNONCE.
     *
     * @Route("/annonces/{slug}-{id}", name="app_announcement_show")
     */
    public function showAppartment(
        Request $request,
        MessageService $msgService,
        $slug,
        Appartment $appartment
    ) {
        if ('Accepté' != $appartment->getStatus()->getName()) {
            return $this->redirectToRoute('home');
        }

        $search = new AppartmentSearch();
        $formSearch = $this->createForm(AppartmentSearchType::class, $search);
        $formSearch->handleRequest($request);

        $contact = new Message();
        $formContact = $this->createForm(MessageType::class, $contact);
        $formContact->handleRequest($request);
        if ($formContact->isSubmitted() && $formContact->isValid()) {
            $data = $msgService->pushMessage($contact, $appartment);
            $this->addFlash('notice', $data['msg']);
        }

        return $this->render('appartment/show.html.twig', [
            'appartment' => $appartment,
            'form' => $formSearch->createView(),
            'formContact' => $formContact->createView(),
        ]);
    }
}
