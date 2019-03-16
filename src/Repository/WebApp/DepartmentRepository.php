<?php

namespace App\Repository\WebApp;

use App\Entity\WebApp\Department;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DepartmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Department::class);
    }

    /**
     * RECUPERE TOUS.
     *
     * @return QueryBuilder|null
     */
    public function findAllQuery(): ?QueryBuilder
    {
        $qb = $this->createQueryBuilder('qb')
            ->orderBy('qb.name', 'ASC');

        return $qb;
    }
}
