<?php

namespace App\Service\WebApp;

use App\Entity\WebApp\City;
use App\Repository\WebApp\CityRepository;

class CityService
{
    private $cityRepository;

    public function __construct(
        CityRepository $cityRepo
    ) {
        $this->cityRepository = $cityRepo;
    }

    /**
     * RECUPERATION DES INFOS DE LA VILLE
     * @param int $id
     * @return array
     */
    public function getCityInformationLocation(int $id): array
    {
        $city = $this->cityRepository->findByKeyValue('id', $id);

        return [
            'lat' => $city->getLat(),
            'lng' => $city->getLng()
        ];
    }
}
