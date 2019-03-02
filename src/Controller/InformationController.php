<?php

namespace App\Controller;

use App\Form\WebApp\ContactType;
use App\Service\Tools\InformationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InformationController extends AbstractController
{
    /**
     * PAGE DE CONTACT
     * @Route("/contact", name="app_contact")
     */
    public function contact(
        Request $request,
        InformationService $informationService
    )
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $informationService->sendContactMessage($form->getData());
            $this->addFlash("notice", $data['msg']);
        }

        return $this->render('information/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * PAGE D'INFORMATION
     * @Route("/information", name="app_info")
     */
    public function information(
        Request $request
    )
    {
        return $this->render('information/information.html.twig', []);
    }
}
