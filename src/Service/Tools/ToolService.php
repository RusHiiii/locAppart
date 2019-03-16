<?php

namespace App\Service\Tools;

use App\Entity\WebApp\Appartment;
use App\Entity\WebApp\User;
use App\Repository\WebApp\AppartmentRepository;
use App\Repository\WebApp\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\File\File;

class ToolService
{
    private $appartmentRepository;

    public function __construct(
        AppartmentRepository $appartmentRepository
    ) {
        $this->appartmentRepository = $appartmentRepository;
    }

    /**
     * GENERE UNE ANNONCE
     * @param Appartment $appartment
     * @return string
     */
    public function generateReference(Appartment $appartment): string
    {
        $reference = [];
        $reference[] = substr($appartment->getType()->getName(), 0, 3);

        $cityName = preg_replace('/\s+/', '', $appartment->getCity()->getName());
        $reference[] = substr($cityName, 0, 5);

        $reference[] = sprintf('%03d', rand(10, 99));

        return implode('', $reference);
    }
}
