<?php

namespace App\Service;

use App\Entity\Appartment;
use App\Entity\User;
use App\Repository\AppartmentRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\File\File;

class MessageService
{
    private $appartmentRepository;
    private $security;

    public function __construct(
    AppartmentRepository $appartmentRepository,
    Security $security
  ) {
        $this->appartmentRepository = $appartmentRepository;
        $this->security = $security;
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
}
