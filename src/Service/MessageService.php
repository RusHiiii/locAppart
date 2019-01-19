<?php

namespace App\Service;

use App\Entity\Appartment;
use App\Entity\User;
use App\Repository\AppartmentRepository;
use App\Repository\MessageRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\File\File;

class MessageService
{
    const MSG_ERROR_NOT_FOUND = 'Message non trouvé';
    const MSG_SUCCESS_DELETE = 'Message supprimé';

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
        return array('appartments' => $appartments, 'count' => $count);
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
            return array('delete' => false, 'data' => self::MSG_ERROR_NOT_FOUND);
        }

        $this->entityManager->remove($message);
        $this->entityManager->flush();

        return array('delete' => true, 'data' => self::MSG_SUCCESS_DELETE);
    }
}
