<?php

namespace App\Repository;

use App\Entity\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class CityRepository
 * @package App\Repository
 */
class CityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, City::class);
    }

    /**
     * @param $key
     * @param $value
     * @return City|null
     */
    public function findByKeyValue($key, $value): ?City
    {
        return $this->findOneBy(array($key => $value));
    }
}
