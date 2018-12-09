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

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/forgottenPassword", name="app_forgotten_password")
     */
    public function forgottenPassword(
        Request $request,
        NotificationService $notificationService
    ) {
        $form = $this->createForm(ForgottenPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->get('forgotten_password');

            $data = $notificationService->generateToken($data['email']);
            if ($data['token']) {
                $data = $notificationService->sendEmail($data['user'], 'Mot de passe oublié', "Cliquer ici pour changer votre mot de passe : <a href=".$data['msg'].">liens</a>");
            }

            $this->addFlash('notice', $data['msg']);
        }

        return $this->render('security/forgotten_password.html.twig', array(
          'form' => $form->createView()
        ));
    }

    /**
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
            $data = $request->request->get('reset_password');

            $data = $userService->resetPassword($token, $data['password']);
            $this->addFlash('notice', $data['msg']);
        }

        return $this->render('security/reset_password.html.twig', array(
          'form' => $form->createView()
        ));
    }
}
