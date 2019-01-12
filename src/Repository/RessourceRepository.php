<?php

namespace App\Repository;

use App\Entity\Ressource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RessourceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ressource::class);
    }

    /**
     * RECUPERATION PAR KEY/VALUE
     * @param  string key
     * @param  string value
     * @return User
     */
    public function findByKeyValue($key, $value): ?Ressource
    {
        return $this->findOneBy(array($key => $value));
    }
}
