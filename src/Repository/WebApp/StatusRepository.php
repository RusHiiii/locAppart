<?php

namespace App\Repository\WebApp;

use App\Entity\WebApp\Status;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class StatusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Status::class);
    }

    /**
     * RECUPERATION PAR LE NOM.
     *
     * @param $name
     *
     * @return object|null
     */
    public function findByName($name)
    {
        $status = $this->findOneBy(
            array('name' => $name)
        );

        return $status;
    }
}
