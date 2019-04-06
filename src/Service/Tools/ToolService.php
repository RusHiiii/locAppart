<?php

namespace App\Service\Tools;

use App\Entity\WebApp\Appartment;
use App\Repository\WebApp\AppartmentRepository;

class ToolService
{
    private $appartmentRepository;

    public function __construct(
        AppartmentRepository $appartmentRepository
    ) {
        $this->appartmentRepository = $appartmentRepository;
    }

    /**
     * GENERE UNE ANNONCE.
     *
     * @param Appartment $appartment
     *
     * @return string
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function generateReference(Appartment $appartment): string
    {
        $reference = [];
        $reference[] = substr($appartment->getType()->getName(), 0, 3);

        $cityName = preg_replace('/\s+/', '', $appartment->getCity()->getName());
        $reference[] = substr($cityName, 0, 5);

        $cpt = $this->appartmentRepository->findNextCounter($appartment->getCity()->getName(), $appartment->getType()->getName());

        $reference[] = sprintf('%03d', $cpt);

        return strtoupper(implode('', $reference));
    }
}
