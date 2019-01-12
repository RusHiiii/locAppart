<?php

namespace App\Repository;

use App\Entity\Status;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class StatusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Status::class);
    }

    /**
     * RECUPERATION PAR LE NOM
     * @param $name
     * @return object|null
     */
    public function findByName($name){
        $status = $this->findOneBy([
            'name' => $name
        ]);

        return $status;
    }
}
