<?php

namespace App\Repository;

use App\Entity\Appartment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AppartmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Appartment::class);
    }

    /**
     * RECUPERE LE DERNIER APPART
     * @return Appartment
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLastAppartment():Appartment
    {
        $qb = $this->createQueryBuilder('qb')
            ->orderBy('qb.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery();

        return $qb->getOneOrNullResult();
    }
}
