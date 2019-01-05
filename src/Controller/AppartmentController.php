<?php

namespace App\Controller;

use App\Entity\Appartment;
use App\Entity\City;
use App\Entity\Status;
use App\Form\AppartmentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AppartmentController extends AbstractController
{
    /**
     * @Route("/account/dashboard", name="app_dashboard")
     */
    public function index()
    {
        return $this->render('appartment/index.html.twig', [
            'controller_name' => 'AppartmentController',
        ]);
    }

    /**
     * @Route("/account/appartment/add", name="app_announcement")
     */
    public function addAnnouncement(
        Request $request
    )
    {

 /*       $appartment = $this->getDoctrine()->getManager()->getRepository(Appartment::class)->find(84);
dd($appartment->getRessources());
        //dd($appartment);
        foreach ($appartment->getRessources() as &$item){
            //dd($item);
            $item->setFile(new File($item->getFile()));
        }
dd($appartment);


        $appartment->setPeople('5/6');
        $appartment->setAdress('zefezf');
        $appartment->setLat('5');
        $appartment->setLng('5');
        $appartment->setDate(new \DateTime('now'));

        $appartment->setReference('rzefzefzef856');
        $appartment->setUser($this->getUser());
        $form = $this->createForm(AppartmentType::class, $appartment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($appartment->getRessources() as &$item){

                $file = $item->getFile();

                $fileName = md5(uniqid()).'.png';

                try {
                    $file->move(
                        $this->getParameter('upload_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                }

                $item->setFile(new File($this->getParameter('upload_directory').'/'.$fileName));
            }


            $em = $this->getDoctrine()->getManager();
            $em->persist($appartment);
            $em->flush();
        }*/

        $appartment = new Appartment();

        $form = $this->createForm(AppartmentType::class, $appartment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

        }

        return $this->render('appartment/add_announcement.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
