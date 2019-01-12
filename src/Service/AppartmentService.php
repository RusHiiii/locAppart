<?php

namespace App\Service;

use App\Entity\Appartment;
use App\Repository\AppartmentRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class AppartmentService
{
    const MSG_SUCCESS_ADD_APP  = 'L\'annonce a été ajouté ! Elle est en cours de modération.';
    const MSG_ERROR_ADD_APP  = 'Une erreur est survenu.';

    private $appartmentRepository;
    private $statusRepository;
    private $entityManager;
    private $security;
    private $fileUploaderService;

    public function __construct(
    AppartmentRepository $appartmentRepository,
    StatusRepository $statusRepository,
    EntityManagerInterface $entityManager,
    FileUploaderService $fileUploaderService,
    Security $security
  ) {
        $this->appartmentRepository = $appartmentRepository;
        $this->entityManager = $entityManager;
        $this->statusRepository = $statusRepository;
        $this->security = $security;
        $this->fileUploaderService = $fileUploaderService;
    }

    /**
     * PUSH UNE ANNONCE
     * @param Appartment $app
     * @param bool $update
     * @return array
     */
    public function pushAppartment(Appartment $app, bool $update)
    {
        if (!$update) {
            $data = $this->addNewAppartment($app);
        }

        return array('push' => $data['result'], 'msg' => $data['msg']);
    }

    /**
     * AJOUT D'UNE ANNONCE
     * @param Appartment $appartment
     * @return array
     */
    private function addNewAppartment(Appartment $appartment)
    {
        $ref = $this->generateReference($appartment);
        $appartment->setReference(strtoupper($ref));

        $status = $this->statusRepository->findByName('at');
        $appartment->setStatus($status);

        $appartment->setUser($this->security->getUser());

        $this->entityManager->persist($appartment);
        $this->entityManager->flush();

        return array('result' => true, 'msg' => self::MSG_SUCCESS_ADD_APP);
    }

    /**
     * GENERE UNE ANNONCE
     * @param Appartment $appartment
     * @return string
     */
    private function generateReference(Appartment $appartment)
    {
        $reference = [];
        $reference[] = substr($appartment->getType()->getName(), 0, 3);

        $cityName = preg_replace('/\s+/', '', $appartment->getCity()->getName());
        $reference[] = substr($cityName, 0, 5);

        $reference[] = sprintf('%03d', rand(10, 99));

        return implode('', $reference);
    }
}
