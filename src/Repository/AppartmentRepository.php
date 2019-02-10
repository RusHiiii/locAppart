<?php

namespace App\Repository;

use App\Entity\Appartment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
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

    /**
     * RECUPERE LES DERNIER APPART
     * @return Appartment
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findXLastAppartment($nb)
    {
        $qb = $this->createQueryBuilder('qb')
            ->orderBy('qb.date', 'DESC')
            ->setMaxResults($nb)
            ->getQuery();

        return $qb->getResult();
    }

    /**
     * RECUPERATION PAR KEY/VALUE
     * @param  string key
     * @param  string value
     * @return User
     */
    public function findByKeyValue($key, $value): ?Appartment
    {
        return $this->findOneBy(
            array($key => $value)
        );
    }

    /**
     * RECUPERATION PAR USER
     * @param  string value
     */
    public function findByUser($user) : array
    {
        return $this->findBy(
            array('user' => $user)
        );
    }

    /**
     * RECUPERATION DES APPART EN LIGNE
     * @return Query
     */
    public function findAllValidQuery() : Query
    {
        $qb = $this->createQueryBuilder('qb')
            ->where('qb.status = :accepted')
            ->setParameter('accepted', 1)
            ->getQuery();

        return $qb;
    }
}
