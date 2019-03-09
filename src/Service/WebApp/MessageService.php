<?php

namespace App\Service\WebApp;

use App\Entity\WebApp\Appartment;
use App\Entity\WebApp\Message;
use App\Entity\WebApp\User;
use App\Repository\WebApp\AppartmentRepository;
use App\Repository\WebApp\MessageRepository;
use App\Repository\WebApp\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\File\File;

class MessageService
{
    const MSG_ERROR_NOT_FOUND = 'Message non trouvé';
    const MSG_SUCCESS_DELETE = 'Message supprimé';
    const MSG_SUCCESS_ADD = 'Message envoyé';
    const MSG_ERROR = 'Erreur lors de l\'envoie';

    private $appartmentRepository;
    private $messageRepository;
    private $entityManager;
    private $security;

    public function __construct(
    AppartmentRepository $appartmentRepository,
    MessageRepository $messageRepository,
    EntityManagerInterface $entityManager,
    Security $security
  ) {
        $this->appartmentRepository = $appartmentRepository;
        $this->security = $security;
        $this->messageRepository = $messageRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * RECUPERATION DES MESSAGES
     * @return array
     */
    public function getAllMessages()
    {
        $count = 0;

        $appartments = $this->appartmentRepository->findByUser($this->security->getUser());

        foreach ($appartments as $appartment) {
            $count += count($appartment->getMessages());
        }
        return [
            'appartments' => $appartments,
            'count' => $count
        ];
    }

    /**
     * SUPPRESSION D'UN MESSAGE
     * @param int $id
     * @return array
     */
    public function removeMessage(int $id)
    {
        $message = $this->messageRepository->findByKeyValue('id', $id);
        if ($message == null) {
            return [
                'delete' => false,
                'data' => self::MSG_ERROR_NOT_FOUND
            ];
        }

        $this->entityManager->remove($message);
        $this->entityManager->flush();

        return [
            'delete' => true,
            'data' => self::MSG_SUCCESS_DELETE
        ];
    }

    /**
     * AJOUT D'UN MESSAGE
     * @param Message $message
     * @return array
     */
    public function pushMessage(Message $message, Appartment $appartment)
    {
        $msg = self::MSG_SUCCESS_ADD;

        $message->setDate(new \DateTime('NOW'));
        $message->setAppartment($appartment);

        try{
            $this->entityManager->persist($message);
            $this->entityManager->flush();
        }catch (\Exception $e){
            $msg = self::MSG_ERROR;
        }

        return [
            'msg' => $msg
        ];
    }
}
