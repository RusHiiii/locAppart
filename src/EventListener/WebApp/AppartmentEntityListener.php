<?php

namespace App\EventListener\WebApp;

use App\Entity\WebApp\Appartment;
use App\Service\Tools\FileUploaderService;
use App\Service\Tools\NotificationService;
use App\Service\Tools\ToolService;
use Doctrine\ORM\Event\LifecycleEventArgs;

class AppartmentEntityListener
{
    private $uploader;
    private $toolService;
    private $notificationService;
    private $templating;

    public function __construct(
        FileUploaderService $uploader,
        ToolService $toolService,
        NotificationService $notificationService,
        \Twig_Environment $templating
    )
    {
        $this->uploader = $uploader;
        $this->toolService = $toolService;
        $this->notificationService = $notificationService;
        $this->templating = $templating;
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
     * FUNCTION D'AVANT SAUVEGARDE
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $uow = $args->getEntityManager()->getUnitOfWork();

        $this->verifyStatus($entity, $uow);
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

    private function verifyStatus($entity, $uow)
    {
        if (!$entity instanceof Appartment) {
            return;
        }

        $changeValue = $uow->getEntityChangeSet($entity);

        if(isset($changeValue['status'])){
            $newStatus = $changeValue['status'][1];

            $data = $this->templating->render('shared/email/status.html.twig', ['appartment' => $entity, 'status' => $newStatus->getDescription()]);
            $this->notificationService->sendEmail([$entity->getUser()], 'Changement de statut', $data);
        }
    }
}
