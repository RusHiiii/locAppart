<?php

namespace App\EventListener;

use App\Entity\Appartment;
use App\Entity\Ressource;
use App\Service\FileUploaderService;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RessourceEntityListener
{
    private $uploader;

    public function __construct(FileUploaderService $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * FONCTION D'AVANT SUPRESSION D'UNE RESSOURCE
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        //UNLINK
    }

    /**
     * FONCTION D'AVANT MAJ D'UNE RESSOURCE
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    /**
     * FONCTION D'AVANT AJOUT D'UNE RESSOURCE
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    /**
     * GESTION DES FICHIER
     * @param $entity
     */
    private function uploadFile($entity)
    {
        if (!$entity instanceof Ressource) {
            return;
        }

        if ($entity->getFile() instanceof UploadedFile) {
            $fileName = $this->uploader->upload($entity->getFile());
            $entity->setPath($fileName['filename']);
        }

        if($entity->getFile() === null){
            $entity->setPath($entity->getPath());
        }
    }
}
