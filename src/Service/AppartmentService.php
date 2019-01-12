<?php

namespace App\Service;

use App\Entity\Appartment;
use App\Repository\AppartmentRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\File\File;

class AppartmentService
{
    const MSG_SUCCESS_ADD_APP  = 'L\'annonce a été ajouté ! Elle est en cours de modération.';
    const MSG_SUCCESS_EDIT_APP  = 'L\'annonce a été modifié !';
    const MSG_ERROR_ADD_APP  = 'Une erreur est survenu.';
    const MSG_ERROR_INFO = 'Aucune données trouvé.';

    private $appartmentRepository;
    private $statusRepository;
    private $entityManager;
    private $security;
    private $fileUploaderService;
    private $targetDirectory;

    public function __construct(
    AppartmentRepository $appartmentRepository,
    StatusRepository $statusRepository,
    EntityManagerInterface $entityManager,
    FileUploaderService $fileUploaderService,
    Security $security,
    $targetDirectory
  ) {
        $this->appartmentRepository = $appartmentRepository;
        $this->entityManager = $entityManager;
        $this->statusRepository = $statusRepository;
        $this->security = $security;
        $this->fileUploaderService = $fileUploaderService;
        $this->targetDirectory = $targetDirectory;
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
            return array('push' => $data['result'], 'msg' => $data['msg']);
        }else{
            $data = $this->editAppartment($app);
            return array('push' => $data['result'], 'msg' => $data['msg']);
        }

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
     * EDITION D'UNE ANNONCE
     * @param Appartment $appartment
     * @return array
     */
    private function editAppartment(Appartment $appartment)
    {
        $this->entityManager->persist($appartment);
        $this->entityManager->flush();

        return array('result' => true, 'msg' => self::MSG_SUCCESS_EDIT_APP);
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

    /**
     * RECUPERE LES INFOS DE L'ANNONCE
     * @param int $id
     * @return array
     */
    public function getAppartmentInfo(int $id)
    {
        $appartement = $this->appartmentRepository->findByKeyValue('id', $id);
        if($appartement == null){
            return array('info' => false, 'data' => self::MSG_ERROR_INFO);
        }

        $ressources = $appartement->getRessources();
        foreach ($ressources as $ressource){
            $ressource->setFile(new File($this->targetDirectory . '/' . $ressource->getFile()));
        }

        return array('info' => true, 'data' => $appartement);
    }
}
