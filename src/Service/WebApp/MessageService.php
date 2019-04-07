<?php

namespace App\Service\WebApp;

use App\Entity\WebApp\Appartment;
use App\Entity\WebApp\Message;
use App\Entity\WebApp\User;
use App\Repository\WebApp\AppartmentRepository;
use App\Repository\WebApp\MessageRepository;
use App\Service\Tools\NotificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class MessageService
{
    private $appartmentRepository;
    private $messageRepository;
    private $entityManager;
    private $notification;
    private $templating;

    // Définition des constantes
    const MSG_ERROR_NOT_FOUND = 'Message non trouvé';
    const MSG_SUCCESS_DELETE = 'Message supprimé';
    const MSG_NEW = 'Nouveau message !';
    const MSG_SUCCESS_ADD = 'Message envoyé';
    const MSG_ERROR = 'Erreur lors de l\'envoie';

    public function __construct(
        AppartmentRepository $appartmentRepository,
        MessageRepository $messageRepository,
        EntityManagerInterface $entityManager,
        NotificationService $notificationService,
        \Twig_Environment $templating
    ) {
        $this->appartmentRepository = $appartmentRepository;
        $this->messageRepository = $messageRepository;
        $this->entityManager = $entityManager;
        $this->notification = $notificationService;
        $this->templating = $templating;
    }

    /**
     * RECUPERATION DES MESSAGES.
     *
     * @return array
     */
    public function getAllMessages(User $user): array
    {
        $count = 0;

        $appartments = $this->appartmentRepository->findByUser($user);

        foreach ($appartments as $appartment) {
            $count += count($appartment->getMessages());
        }

        return [
            'appartments' => $appartments,
            'count' => $count,
        ];
    }

    /**
     * SUPPRESSION D'UN MESSAGE.
     *
     * @param int $id
     *
     * @return array
     */
    public function removeMessage(int $id): array
    {
        $message = $this->messageRepository->findByKeyValue('id', $id);
        if (null == $message) {
            return [
                'delete' => false,
                'data' => self::MSG_ERROR_NOT_FOUND,
            ];
        }

        $this->entityManager->remove($message);
        $this->entityManager->flush();

        return [
            'delete' => true,
            'data' => self::MSG_SUCCESS_DELETE,
        ];
    }

    /**
     * AJOUT D'UN MESSAGE.
     *
     * @param Message $message
     * @param Appartment $appartment
     *
     * @return array
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function pushMessage(Message $message, Appartment $appartment): array
    {
        $msg = self::MSG_SUCCESS_ADD;

        $message->setDate(new \DateTime('NOW'));
        $message->setAppartment($appartment);

        try {
            $this->entityManager->persist($message);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            $msg = self::MSG_ERROR;
        }

        if($appartment->getUser()->getNotification()){
            $dataTemplate = $this->templating->render('shared/email/notification.html.twig', ['appartment' => $appartment, 'sender' => $message->getEmail()]);

            return $this->notification->sendEmail([$appartment->getUser()], self::MSG_NEW, $dataTemplate);
        }

        return ['msg' => $msg];
    }
}
