<?php

namespace App\Service\WebApp;

use App\Entity\WebApp\Appartment;
use App\Entity\WebApp\User;
use App\Repository\WebApp\AppartmentRepository;
use App\Repository\WebApp\StatusRepository;
use App\Service\Tools\ToolService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\File\File;

class AppartmentService
{
    private $appartmentRepository;
    private $statusRepository;
    private $entityManager;
    private $security;
    private $targetDirectory;
    private $paginator;
    private $toolService;

    // Définition des constantes
    const MSG_SUCCESS_ADD_APP     = 'L\'annonce a été ajouté ! Elle est en cours de modération.';
    const MSG_SUCCESS_EDIT_APP    = 'L\'annonce a été modifié !';
    const MSG_SUCCESS_DELETE_APP  = 'L\'annonce a été supprimé !';
    const MSG_ERROR_ADD_APP       = 'Une erreur est survenu.';
    const MSG_ERROR_EDIT_APP      = 'Une erreur est survenu lors de la mise à jour.';
    const MSG_ERROR_INFO          = 'Aucune données trouvé.';
    const MSG_ERROR_REMOVE_APP    = 'Une erreur est survenu lors de la suppression.';

    public function __construct(
        AppartmentRepository $appartmentRepository,
        StatusRepository $statusRepository,
        EntityManagerInterface $entityManager,
        Security $security,
        ToolService $toolService,
        PaginatorInterface $paginator,
        $targetDirectory
    ) {
        $this->appartmentRepository = $appartmentRepository;
        $this->entityManager        = $entityManager;
        $this->statusRepository     = $statusRepository;
        $this->security             = $security;
        $this->targetDirectory      = $targetDirectory;
        $this->toolService          = $toolService;
        $this->paginator            = $paginator;
    }

    /**
     * PUSH UNE ANNONCE
     * @param Appartment $app
     * @param bool $update
     * @return array
     */
    public function pushAppartment(Appartment $app, bool $update): array
    {
        if (!$update) {
            $data = $this->addAppartment($app);
        } else {
            $data = $this->editAppartment($app);
        }

        return [ 'msg' => $data ];
    }

    /**
     * AJOUT D'UNE ANNONCE
     * @param \App\Entity\WebApp\Appartment $appartment
     * @return string
     */
    private function addAppartment(Appartment $appartment): string
    {
        $msg = self::MSG_SUCCESS_ADD_APP;

        $status = $this->statusRepository->findByName('En attente de modération');
        $appartment->setStatus($status);

        $appartment->setUser($this->security->getUser());

        $this->entityManager->persist($appartment);

        try{
            $this->entityManager->flush();
        }catch (\Exception $e){
            $msg = self::MSG_ERROR_ADD_APP;
        }

        return $msg;
    }

    /**
     * EDITION D'UNE ANNONCE
     * @param Appartment $appartment
     * @return array
     */
    private function editAppartment(Appartment $appartment): string
    {
        $msg = self::MSG_SUCCESS_EDIT_APP;

        $this->entityManager->persist($appartment);
        try{
            $this->entityManager->flush();
        }catch (\Exception $e){
            $msg = self::MSG_ERROR_EDIT_APP;
        }

        return $msg;
    }

    /**
     * RECUPERE LES INFOS DE L'ANNONCE
     * @param int $id
     * @return array
     */
    public function getAppartmentInfo(int $id): array
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
    public function getAppartmentsByUser(User $user): array
    {
        $data = $this->appartmentRepository->findByUser($user);

        return [ 'data' => $data ];
    }

    /**
     * SUPPRESSION D'UNE ANNONCE
     * @param int $id
     * @return array
     */
    public function removeAppartment(int $id): array
    {
        $msg = self::MSG_SUCCESS_DELETE_APP;
        $result = true;

        $appartment = $this->appartmentRepository->findByKeyValue('id', $id);
        if ($appartment == null) {
            return [
                'delete' => false,
                'data' => self::MSG_ERROR_INFO
            ];
        }

        $this->entityManager->remove($appartment);
        try{
            $this->entityManager->flush();
        }catch (\Exception $e){
            $result = false;
            $msg = self::MSG_ERROR_REMOVE_APP;
        }

        return [
            'delete' => $result,
            'data' => $msg
        ];
    }

    /**
     * RECUP DES X LAST ANNONCES
     * @param int $nb
     * @return \App\Entity\WebApp\Appartment
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getXLastAppartment(int $nb)
    {
        $appartments = $this->appartmentRepository->findXLastAppartment($nb);
        return $appartments;
    }

    /**
     * RECUPERATION LISTING
     * @return array
     */
    public function getAllAvailableAppartment($currentPage, $search, $type)
    {
        $appartments = $this->paginator->paginate(
            $this->appartmentRepository->findAllValidQuery($search, $type),
            $currentPage,
            5
        );
        return $appartments;
    }
}
