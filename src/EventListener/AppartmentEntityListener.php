<?php

namespace App\EventListener;

use App\Entity\Appartment;
use App\Service\FileUploaderService;
use Doctrine\ORM\Event\LifecycleEventArgs;

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
     * @throws \Exception
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->manageCreationDate($entity);
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
