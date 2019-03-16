<?php

namespace App\Controller;

use App\Service\WebApp\AppartmentService;
use App\Service\WebApp\CityService;
use App\Service\WebApp\MessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class XhrController extends AbstractController
{
    /**
     * RECUPERATION DES INFOS DE LA VILLE.
     *
     * @Route("/xhr/ville", condition="request.isXmlHttpRequest()")
     */
    public function getCityInformation(
        Request $request,
        CityService $cityService
    ) {
        $cityId = $request->request->get('city');

        $city = $cityService->getCityInformationLocation($cityId);

        return new JsonResponse(['data' => $city]);
    }

    /**
     * SUPPRESSION ANNONCE.
     *
     * @Route("/xhr/appartement/suppression", condition="request.isXmlHttpRequest()")
     */
    public function removeAppartment(
        Request $request,
        AppartmentService $appService
    ) {
        $appId = $request->request->get('appartment');

        $data = $appService->removeAppartment($appId);

        return new JsonResponse(['data' => $data]);
    }

    /**
     * UPPRESSION MESSAGE.
     *
     * @Route("/xhr/message/suppression", condition="request.isXmlHttpRequest()")
     */
    public function removeMessage(
        Request $request,
        MessageService $messageService
    ) {
        $appId = $request->request->get('message');

        $data = $messageService->removeMessage($appId);

        return new JsonResponse(['data' => $data]);
    }
}
