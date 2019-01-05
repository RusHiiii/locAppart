<?php

namespace App\Controller;

use App\Service\CityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class XhrController extends AbstractController
{
    /**
     * @Route("/xhr/city", condition="request.isXmlHttpRequest()")
     */
    public function getCityInformation(
        Request $request,
        CityService $cityService
    )
    {
        $cityId = $request->request->get('city');

        $city = $cityService->getCityInformationLocation($cityId);

        return new JsonResponse(
            array('data' => $city)
        );
    }
}
