<?php

namespace App\Service;

use App\Entity\Appartment;
use App\Entity\User;
use App\Repository\AppartmentRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\File\File;

class AppartmentService
{
    const MSG_SUCCESS_ADD_APP  = 'L\'annonce a été ajouté ! Elle est en cours de modération.';
    const MSG_SUCCESS_EDIT_APP  = 'L\'annonce a été modifié !';
    const MSG_SUCCESS_DELETE_APP  = 'L\'annonce a été supprimé !';
    const MSG_ERROR_ADD_APP  = 'Une erreur est survenu.';
    const MSG_ERROR_INFO = 'Aucune données trouvé.';

    private $appartmentRepository;
    private $statusRepository;
    private $entityManager;
    private $security;
    private $targetDirectory;
    private $toolService;

    public function __construct(
    AppartmentRepository $appartmentRepository,
    StatusRepository $statusRepository,
    EntityManagerInterface $entityManager,
    Security $security,
    ToolService $toolService,
    $targetDirectory
  ) {
        $this->appartmentRepository = $appartmentRepository;
        $this->entityManager = $entityManager;
        $this->statusRepository = $statusRepository;
        $this->security = $security;
        $this->targetDirectory = $targetDirectory;
        $this->toolService = $toolService;
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
            $data = $this->addAppartment($app);
        } else {
            $data = $this->editAppartment($app);
        }

        return [
            'push' => $data['result'],
            'msg' => $data['msg']
        ];
    }

    /**
     * AJOUT D'UNE ANNONCE
     * @param Appartment $appartment
     * @return array
     */
    private function addAppartment(Appartment $appartment)
    {
        $ref = $this->toolService->generateReference($appartment);
        $appartment->setReference(strtoupper($ref));

        $status = $this->statusRepository->findByName('En attente de modération');
        $appartment->setStatus($status);

        $appartment->setUser($this->security->getUser());

        $this->entityManager->persist($appartment);
        $this->entityManager->flush();

        return [
            'result' => true,
            'msg' => self::MSG_SUCCESS_ADD_APP
        ];
    }

    /**
     * EDITION D'UNE ANNONCE
     * @param Appartment $appartment
     * @return array
     */
    private function editAppartment(Appartment $appartment)
    {
        $this->entityManager->persist($appartment);
        $this->entityManager->flush();

        return [
            'result' => true,
            'msg' => self::MSG_SUCCESS_EDIT_APP
        ];
    }

    /**
     * RECUPERE LES INFOS DE L'ANNONCE
     * @param int $id
     * @return array
     */
    public function getAppartmentInfo(int $id)
    {
        $appartement = $this->appartmentRepository->findByKeyValue('id', $id);
        if ($appartement == null) {
            return [
                'info' => false,
                'data' => self::MSG_ERROR_INFO
            ];
        }

        $ressources = $appartement->getRessources();
        foreach ($ressources as $ressource) {
            $ressource->setFile(new File($this->targetDirectory . '/' . $ressource->getPath()));
        }

        return [
            'info' => true,
            'data' => $appartement
        ];
    }

    /**
     * RECUPERE LES L'ANNONCES D'UN USER
     * @param int $id
     * @return array
     */
    public function getAppartmentsByUser(User $user)
    {
        $data = $this->appartmentRepository->findByUser($user);

        return [
            'info' => true,
            'data' => $data
        ];
    }

    /**
     * SUPPRESSION D'UNE ANNONCE
     * @param int $id
     * @return array
     */
    public function removeAppartment(int $id)
    {
        $appartment = $this->appartmentRepository->findByKeyValue('id', $id);
        if ($appartment == null) {
            return [
                'delete' => false,
                'data' => self::MSG_ERROR_INFO
            ];
        }

        $this->entityManager->remove($appartment);
        $this->entityManager->flush();

        return [
            'delete' => true,
            'data' => self::MSG_SUCCESS_DELETE_APP
        ];
    }

    /**
     * RECUP DES X LAST ANNONCES
     * @param int $nb
     * @return Appartment
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getXLastAppartment(int $nb)
    {
        $appartments = $this->appartmentRepository->findXLastAppartment($nb);
        return $appartments;
    }
}
