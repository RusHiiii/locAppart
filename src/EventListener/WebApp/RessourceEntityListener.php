<?php

namespace App\EventListener\WebApp;

use App\Entity\WebApp\Appartment;
use App\Entity\WebApp\Ressource;
use App\Service\Tools\FileUploaderService;
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
        $entity = $args->getEntity();

        if (!$entity instanceof Ressource) {
            return;
        }

        unlink($this->uploader->getTargetDirectory() . '/' . $entity->getPath());
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
    }
}
