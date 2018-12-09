<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use App\Entity\User;
use App\Service\UserService;

class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profil")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(
      Request $request,
      UserService $userService
    ) {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userService->registerUser($user);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/register.html.twig', array(
          'form' => $form->createView()
        ));
    }
}
