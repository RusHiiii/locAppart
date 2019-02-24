<?php

namespace App\EventListener;

use App\Entity\Appartment;
use App\Service\FileUploaderService;
use App\Service\ToolService;
use Doctrine\ORM\Event\LifecycleEventArgs;

class AppartmentEntityListener
{
    private $uploader;
    private $toolService;

    public function __construct(
        FileUploaderService $uploader,
        ToolService $toolService
    )
    {
        $this->uploader = $uploader;
        $this->toolService = $toolService;
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

        $this->manageReference($entity);
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

    /**
     * GESTION DE LA REF
     * @param $entity
     * @throws \Exception
     */
    private function manageReference($entity)
    {
        if (!$entity instanceof Appartment) {
            return;
        }

        $entity->setReference(strtoupper($this->toolService->generateReference($entity)));
    }
}
