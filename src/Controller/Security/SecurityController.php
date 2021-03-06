<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\WebApp\ForgottenPasswordType;
use App\Form\WebApp\ResetPasswordType;
use App\Service\WebApp\UserService;

class SecurityController extends AbstractController
{
    /**
     * LOGIN DU SITE.
     *
     * @Route("/connexion", name="app_login")
     */
    public function login(
        AuthenticationUtils $authenticationUtils
    ) {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * DECONNEXION DU SITE.
     *
     * @Route("/deconnexion", name="app_logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('home');
    }

    /**
     * MDP CHANGEMENT.
     *
     * @Route("/changement-mdp", name="app_forgotten_password")
     */
    public function forgottenPassword(
        Request $request,
        UserService $userService
    ) {
        $form = $this->createForm(ForgottenPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $data = $userService->forgotPassword($formData['email']);

            $this->addFlash('notice', $data['msg']);
        }

        return $this->render('security/forgotten_password.html.twig', [
          'form' => $form->createView(),
        ]);
    }

    /**
     * RESET DU MOT DE PASSE.
     *
     * @Route("/reset-mdp/{token}", name="app_reset_password")
     */
    public function resetPassword(
      Request $request,
      string $token,
      UserService $userService
    ) {
        $form = $this->createForm(ResetPasswordType::class, array('token' => $token));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $data = $userService->resetPassword($token, $data['password']);
            $this->addFlash('notice', $data['msg']);
        }

        return $this->render('security/reset_password.html.twig', [
          'form' => $form->createView(),
        ]);
    }
}
