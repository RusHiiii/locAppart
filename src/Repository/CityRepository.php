<?php

namespace App\Repository;

use App\Entity\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, City::class);
    }

    /**
     * RECUPERE UNE VILLE PAR N'IMPORTE QUELLE KEY/VALUE
     * @param $key
     * @param $value
     * @return City|null
     */
    public function findByKeyValue($key, $value): ?City
    {
        return $this->findOneBy(array($key => $value));
    }
}
