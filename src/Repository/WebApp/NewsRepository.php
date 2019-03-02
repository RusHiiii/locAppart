<?php

namespace App\Repository\WebApp;

use App\Entity\WebApp\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class NewsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function findLastestNews(int $limit)
    {
        $qb = $this->createQueryBuilder('qb')
            ->orderBy('qb.created', 'DESC')
            ->setMaxResults($limit)
            ->getQuery();

        return $qb->getResult();
    }
}
