<?php

namespace App\Service;

use App\Entity\City;
use App\Repository\CityRepository;

class CityService
{

    private $cityRepository;

    public function __construct(
    CityRepository $cityRepo
  ) {
        $this->cityRepository = $cityRepo;
    }

    /**
     * Récupération des informations de la ville
     * @param int $id
     * @return array
     */
    public function getCityInformationLocation(int $id){
        $city = $this->cityRepository->findByKeyValue('id', $id);

        return array(
            'lat' => $city->getLat(),
            'lng' => $city->getLng()
        );
    }
}
