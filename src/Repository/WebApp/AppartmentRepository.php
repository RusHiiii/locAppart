<?php

namespace App\Repository\WebApp;

use App\Entity\WebApp\Appartment;
use App\Entity\WebApp\Price;
use App\Entity\Search\AppartmentSearch;
use App\Entity\WebApp\City;
use App\Entity\WebApp\Department;
use App\Entity\WebApp\Status;
use App\Entity\WebApp\Type;
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
     * RECUPERE LE DERNIER APPART.
     *
     * @return \App\Entity\WebApp\Appartment
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLastAppartment(): Appartment
    {
        $qb = $this->createQueryBuilder('qb')
            ->orderBy('qb.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery();

        return $qb->getOneOrNullResult();
    }

    /**
     * RECUPERE LES DERNIER APPART.
     *
     * @return \App\Entity\WebApp\Appartment
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findXLastAppartment($nb)
    {
        $qb = $this->createQueryBuilder('qb')
            ->orderBy('qb.date', 'DESC')
            ->setMaxResults($nb)
            ->innerJoin(Status::class, 's', 'WITH', 's.id = qb.status')
            ->where('s.name = :accepted')
            ->setParameters([
                'accepted' => 'Accepté',
            ])
            ->getQuery();

        return $qb->getResult();
    }

    /**
     * RECUPERATION PAR KEY/VALUE.
     *
     * @param  string key
     * @param  string value
     *
     * @return \App\Entity\WebApp\Appartment
     */
    public function findByKeyValue($key, $value): ?Appartment
    {
        return $this->findOneBy(
            array($key => $value)
        );
    }

    /**
     * FIND BY USER.
     *
     * @param $user
     *
     * @return array
     */
    public function findByUser($user): array
    {
        return $this->findBy(
            array('user' => $user)
        );
    }

    /**
     * RECUP COMPTEUR
     *
     * @param $city
     * @param $type
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findNextCounter($city, $type)
    {
        $qb = $this->createQueryBuilder('qb')
            ->select('count(qb.id)')
            ->innerJoin(City::class, 'c', 'WITH', 'c.id = qb.city')
            ->innerJoin(Type::class, 't', 'WITH', 't.id = qb.type')
            ->where('c.name = :city')
            ->andWhere('t.name = :type')
            ->setParameters([
                'city' => $city,
                'type' => $type,
            ])
            ->getQuery();

        return $qb->getSingleScalarResult();
    }

    /**
     * RECUPERATION DES APPART EN LIGNE.
     *
     * @return Query
     */
    public function findAllValidQuery(AppartmentSearch $search, $type): Query
    {
        $qb = $this->createQueryBuilder('qb')
            ->innerJoin(City::class, 'c', 'WITH', 'c.id = qb.city')
            ->innerJoin(Department::class, 'd', 'WITH', 'd.id = c.department')
            ->innerJoin(Type::class, 't', 'WITH', 't.id = qb.type')
            ->where('qb.status = :accepted')
            ->andWhere('t.name = :type')
            ->setParameters([
                'accepted' => 4,
                'type' => $type,
            ]);

        if ($search->getCity()) {
            $qb
                ->andWhere('c.name = :city')
                ->setParameter('city', $search->getCity());
        }

        if ($search->getDepartment()) {
            $qb
                ->andWhere('d.name = :department')
                ->setParameter('department', $search->getDepartment());
        }

        if ($search->getDescription()) {
            $qb
                ->andWhere('qb.title LIKE :description')
                ->setParameter('description', '%'.$search->getDescription().'%');
        }

        if (null !== $search->getGarage()) {
            $qb
                ->andWhere('qb.garage = :garage')
                ->setParameter('garage', $search->getGarage());
        }

        if (null !== $search->getLocker()) {
            $qb
                ->andWhere('qb.locker = :locker')
                ->setParameter('locker', $search->getLocker());
        }

        if (null !== $search->getMaxPrice()) {
            $qb
                ->innerJoin(Price::class, 'p', 'WITH', 'p.appartment = qb.id')
                ->andWhere('p.price <= :price')
                ->setParameter('price', $search->getMaxPrice());
        }

        return $qb->getQuery();
    }
}
