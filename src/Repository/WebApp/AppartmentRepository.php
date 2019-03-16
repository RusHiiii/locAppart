<?php

namespace App\Repository\WebApp;

use App\Entity\WebApp\Appartment;
use App\Entity\WebApp\Price;
use App\Entity\Search\AppartmentSearch;
use App\Entity\WebApp\City;
use App\Entity\WebApp\Department;
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
     * RECUPERE LE DERNIER APPART
     * @return \App\Entity\WebApp\Appartment
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
     * @return \App\Entity\WebApp\Appartment
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findXLastAppartment($nb)
    {
        $qb = $this->createQueryBuilder('qb')
            ->orderBy('qb.date', 'DESC')
            ->setMaxResults($nb)
            ->where('qb.status = :accepted')
            ->setParameters([
                'accepted' => 1
            ])
            ->getQuery();

        return $qb->getResult();
    }

    /**
     * RECUPERATION PAR KEY/VALUE
     * @param  string key
     * @param  string value
     * @return \App\Entity\WebApp\Appartment
     */
    public function findByKeyValue($key, $value): ?Appartment
    {
        return $this->findOneBy(
            array($key => $value)
        );
    }

    /**
     * FIND BY USER
     * @param $user
     * @return array
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
    public function findAllValidQuery(AppartmentSearch $search, $type) : Query
    {
        $qb = $this->createQueryBuilder('qb')
            ->innerJoin(City::class, 'c', 'WITH', 'c.id = qb.city')
            ->innerJoin(Department::class, 'd', 'WITH', 'd.id = c.department')
            ->innerJoin(Type::class, 't', 'WITH', 't.id = qb.type')
            ->where('qb.status = :accepted')
            ->andWhere('t.name = :type')
            ->setParameters([
                'accepted' => 1,
                'type' => $type
            ]);

        if($search->getCity()){
            $qb
                ->andWhere('c.name = :city')
                ->setParameter('city', $search->getCity());
        }

        if($search->getDepartment()){
            $qb
                ->andWhere('d.name = :department')
                ->setParameter('department', $search->getDepartment());
        }

        if($search->getDescription()){
            $qb
                ->andWhere('qb.title LIKE :description')
                ->setParameter('description', '%'.$search->getDescription().'%');
        }

        if($search->getGarage() !== null){
            $qb
                ->andWhere('qb.garage = :garage')
                ->setParameter('garage', $search->getGarage());
        }

        if($search->getLocker() !== null){
            $qb
                ->andWhere('qb.locker = :locker')
                ->setParameter('locker', $search->getLocker());
        }

        if($search->getMaxPrice() !== null){
            $qb
                ->innerJoin(Price::class, 'p', 'WITH', 'p.appartment = qb.id')
                ->andWhere('p.price <= :price')
                ->setParameter('price', $search->getMaxPrice());
        }

        return $qb->getQuery();
    }
}
