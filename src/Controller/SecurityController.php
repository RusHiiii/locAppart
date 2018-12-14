<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use App\Entity\User;
use App\Form\ForgottenPasswordType;
use App\Form\ResetPasswordType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Service\NotificationService;
use App\Service\UserService;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * Authentification
     * @Route("/login", name="app_login")
     */
    public function login(
        AuthenticationUtils $authenticationUtils
    )
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * Déconnexion
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('home');
    }

    /**
     * Mot de passe oublié
     * @Route("/forgottenPassword", name="app_forgotten_password")
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

        return $this->render('security/forgotten_password.html.twig', array(
          'form' => $form->createView()
        ));
    }

    /**
     * Reset du mot de passe
     * @Route("/reset_password/{token}", name="app_reset_password")
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

        return $this->render('security/reset_password.html.twig', array(
          'form' => $form->createView()
        ));
    }
}
