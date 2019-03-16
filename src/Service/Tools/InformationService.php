<?php

namespace App\Service\Tools;

use App\Repository\WebApp\UserRepository;

class InformationService
{
    private $notificationService;
    private $userRepository;
    private $templating;

    // Définition des constantes
    const MSG_CONTACT_EMAIL = 'Contact';
    const MSG_CONTACT_EMAIL_SUCCESS = 'Message envoyé !';

    public function __construct(
        NotificationService $notificationService,
        UserRepository $userRepository,
        \Twig_Environment $templating
  ) {
        $this->notificationService = $notificationService;
        $this->templating = $templating;
        $this->userRepository = $userRepository;
    }

    /**
     * ENVOIE D'UN MESSAGE.
     *
     * @param array $data
     *
     * @return array
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendContactMessage(array $data): array
    {
        $users = $this->userRepository->findAllRole('%ADMIN%');

        // Notification par mail
        $data = $this->templating->render('shared/email/contact.html.twig', ['data' => $data]);
        $this->notificationService->sendEmail($users, self::MSG_CONTACT_EMAIL, $data);

        return ['msg' => self::MSG_CONTACT_EMAIL_SUCCESS];
    }
}
