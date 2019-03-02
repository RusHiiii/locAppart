<?php

namespace App\Repository\WebApp;

use App\Entity\WebApp\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MessageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Message::class);
    }

    /**
     * RECUPERATION PAR KEY/VALUE
     * @param  string key
     * @param  string value
     * @return Message
     */
    public function findByKeyValue($key, $value): ?Message
    {
        return $this->findOneBy(
            array($key => $value)
        );
    }
}
