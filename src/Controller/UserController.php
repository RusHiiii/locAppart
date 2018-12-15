<?php

namespace App\Controller;

use App\Form\ForgottenPasswordType;
use App\Form\ResetPasswordType;
use App\Form\UpdatePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use App\Form\UserEditType;
use App\Entity\User;
use App\Service\UserService;

class UserController extends AbstractController
{
    /**
     * HomePage du user
     * @Route("/account/profile", name="app_profil")
     */
    public function index(
        Request $request,
        UserService $userService
    )
    {
        $user = $this->getUser();
        $formUpdate = $this->createForm(UserEditType::class, $user);
        $formPswd = $this->createForm(UpdatePasswordType::class, $user);

        $formUpdate->handleRequest($request);
        if ($formUpdate->isSubmitted() && $formUpdate->isValid()) {
            $data = $userService->pushUser($user, false);
            $this->addFlash('notice', $data['msg']);
        }

        $formPswd->handleRequest($request);
        if ($formPswd->isSubmitted() && $formPswd->isValid()) {
            $data = $userService->updatePassword($user, $user->getPassword());
            $this->addFlash('notice', $data['msg']);
        }

        return $this->render('user/index.html.twig', [
            'formUpdate' => $formUpdate->createView(),
            'formPswd' => $formPswd->createView()
        ]);
    }

    /**
     * Enregistrement du user
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
            $data = $userService->pushUser($user, true);
            $this->addFlash('notice', $data['msg']);

            if($data['register']){
                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('user/register.html.twig', array(
          'form' => $form->createView()
        ));
    }
}
