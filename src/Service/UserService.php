<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private $userRepository;
    private $passwordEncoder;
    private $entityManager;
    private $templating;
    private $notification;

    public function __construct(
    UserRepository $userRepo,
    UserPasswordEncoderInterface $passwordEncoder,
    EntityManagerInterface $entityManager,
    \Twig_Environment $templating,
    NotificationService $notificationService
  ) {
        $this->userRepository = $userRepo;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->templating = $templating;
        $this->notification = $notificationService;
    }

    /**
     * Permet de enregistrer un user
     * @param User $user
     * @return array
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function registerUser(User $user)
    {
        if($this->userRepository->findByKeyValue('email', $user->getEmail())){
            return array('register' => false, 'msg' => 'L\'email est déjà utilisé !');
        }

        $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);
        $user->setEmail($user->getEmail());
        $user->setFirstname($user->getFirstname());
        $user->setLastname($user->getLastname());
        $user->setDate(new \DateTime('now'));
        $user->setGender($user->getGender());

        $data = $this->templating->render('Shared/email/register.html.twig', ['user' => $user]);
        $this->notification->sendEmail($user, 'Bienvenue sur locAppart.fr !', $data);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return array('register' => true, 'msg' => 'Inscription validée !');
    }

    /**
     * Permet de reset le mot de passe
     * @param $token
     * @param $password
     * @return array
     */
    public function resetPassword($token, $password)
    {
        $user = $this->userRepository->findByKeyValue('resetToken', $token);

        if ($user === null) {
            return array('error' => true, 'msg' => 'Token Inconnu');
        }

        $user->setResetToken(null);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return array('error' => false, 'msg' => 'Mot de passe mis à jour');
    }

    /**
     * Procedure de changement de mot de passe
     * @param $email
     * @return array
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function forgotPassword($email)
    {
        $data = $this->notification->generateToken($email);

        if ($data['token']) {
            $dataTemplate = $this->templating->render('Shared/email/reset_password.html.twig', ['data' => $data['msg']]);
            $this->notification->sendEmail($data['user'], 'Mot de passe oublié', $dataTemplate);

            return array('msg' => 'Email envoyé !');
        }

        return array('msg' => 'Problème lors de l\'envoie du mail');
    }
}
