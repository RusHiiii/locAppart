<?php

namespace App\Service\Tools;

use App\Entity\WebApp\City;
use App\Repository\WebApp\CityRepository;
use App\Repository\WebApp\UserRepository;
use App\Service\Tools\NotificationService;

class InformationService
{
    const MSG_CONTACT_EMAIL  = 'Contact';
    const MSG_CONTACT_EMAIL_SUCCESS  = 'Message envoyé !';

    private $notificationService;
    private $userRepository;
    private $templating;

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
     * ENVOIE D'UN MESSAGE
     * @param array $data
     * @return array
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendContactMessage(array $data)
    {
        $users = $this->userRepository->findAllRole('%ADMIN%');

        $data = $this->templating->render('Shared/email/contact.html.twig', ['data' => $data]);
        $this->notificationService->sendEmail($users, self::MSG_CONTACT_EMAIL, $data);

        return [
            'send' => true,
            'msg' => self::MSG_CONTACT_EMAIL_SUCCESS
        ];
    }
}
