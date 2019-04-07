<?php

namespace App\Controller;

use App\Service\WebApp\MessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MessageController extends AbstractController
{
    /**
     * DASHBOARD DU COMPTE.
     *
     * @Route("/mon-compte/mes-messages", name="app_messages")
     */
    public function index(
        Request $request,
        MessageService $messageService
    ) {
        $data = $messageService->getAllMessages($this->getUser());

        return $this->render('message/index.html.twig', [
            'appartments' => $data['appartments'],
            'count' => $data['count'],
        ]);
    }
}
