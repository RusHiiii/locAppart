<?php

namespace App\Repository\WebApp;

use App\Entity\WebApp\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
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

    /**
     * RECUPERE TOUS
     * @return QueryBuilder|null
     */
    public function findAllQuery(): ?QueryBuilder
    {
        $qb = $this->createQueryBuilder('qb')
            ->orderBy('qb.name', 'ASC');

        return $qb;
    }
}
