<?php

namespace App\EventListener;

use App\Entity\Appartment;
use App\Service\FileUploaderService;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AppartmentEntityListener
{
    private $uploader;

    public function __construct(FileUploaderService $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * FONCTION D'AVANT SAUVEGARDE
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
        $this->manageCreationDate($entity);
    }

    /**
     * GESTION DES FICHIER
     * @param $entity
     */
    private function uploadFile($entity)
    {
        if (!$entity instanceof Appartment) {
            return;
        }

        $files = $entity->getRessources();

        foreach ($files as $file){
            if ($file->getFile() instanceof UploadedFile) {
                $fileName = $this->uploader->upload($file->getFile());
                $file->setFile($fileName['filename']);
            }
        }
    }

    /**
     * GESTION DE LA DATE DE CREATION
     * @param $entity
     * @throws \Exception
     */
    private function manageCreationDate($entity)
    {
        if (!$entity instanceof Appartment) {
            return;
        }

        $entity->setDate(new \DateTime('NOW'));
    }
}