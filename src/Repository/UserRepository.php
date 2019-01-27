<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * RECUPERATION PAR KEY/VALUE
     * @param  string key
     * @param  string value
     * @return User
     */
    public function findByKeyValue($key, $value): ?User
    {
        return $this->findOneBy(
            array($key => $value)
        );
    }

    /**
     * RECUPERATION USER PAR ROLE
     * @param $role
     * @return mixed
     */
    public function findAllRole($role){
        $result = $this->createQueryBuilder('qb')
                ->where('qb.roles LIKE :role')
                ->setParameter('role', $role)
                ->getQuery()
                ->getResult();

        return $result;
    }
}
