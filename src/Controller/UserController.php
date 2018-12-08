<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

          /* SERVICE ! */
          $password = $passwordEncoder->encodePassword($user, $user->getPassword());
          $user->setPassword($password);
          $user->setEmail($user->getEmail());
          $user->setFirstname($user->getFirstname());
          $user->setLastname($user->getLastname());
          $user->setDate(new \DateTime('now'));
          $user->setGender($user->getGender());

          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($user);
          $entityManager->flush();

          return $this->redirectToRoute('app_login');
        }

        return $this->render('user/register.html.twig', array(
          'form' => $form->createView()
        ));
    }
}
