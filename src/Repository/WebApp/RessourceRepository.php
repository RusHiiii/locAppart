<?php

namespace App\Repository\WebApp;

use App\Entity\WebApp\Ressource;
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
     * @return \App\Entity\WebApp\Ressource
     */
    public function findByKeyValue($key, $value): ?Ressource
    {
        return $this->findOneBy(array($key => $value));
    }
}
