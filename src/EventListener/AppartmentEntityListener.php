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

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
        $this->manageCreationDate($entity);
    }

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
            } elseif ($file instanceof File) {
                //TODO
            }
        }
    }

    private function manageCreationDate($entity)
    {

        if (!$entity instanceof Appartment) {
            return;
        }

        $entity->setDate(new \DateTime('NOW'));
    }
}