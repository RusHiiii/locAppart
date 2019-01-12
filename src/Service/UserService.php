<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    const MSG_REGISTER_EMAIL  = 'Bienvenue sur locAppart.fr !';
    const MSG_REGISTER_VALID  = 'Inscription validée !';
    const MSG_UPDATE_VALID    = 'Votre compte a été mis à jours !';
    const MSG_INVALID_TOKEN   = 'Token Inconnu';
    const MSG_PASSWORD_UPDATE = 'Mot de passe mis à jour';
    const MSG_FORGOTTEN_PSWD  = 'Mot de passe oublié';
    const MSG_EMAIL_SEND      = 'Email envoyé !';
    const MSG_EMAIL_ERROR     = 'Problème lors de l\'envoie du mail';

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
     * INSCRIPTION D'UN UTILISATEUR
     * @param User $user
     * @return array
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function registerUser(User $user)
    {
        $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);
        $user->setDate(new \DateTime('now'));

        $data = $this->templating->render('Shared/email/register.html.twig', ['user' => $user]);
        $this->notification->sendEmail($user, self::MSG_REGISTER_EMAIL, $data);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return array('register' => true, 'msg' => self::MSG_REGISTER_VALID);
    }

    /**
     * ENTRYPOINT USER
     * @param User $user
     * @param bool $add
     * @return array
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function pushUser(User $user, bool $add)
    {
        if ($add) {
            return $this->registerUser($user);
        }
        return $this->updateUser($user);
    }

    /**
     * MAJ DU USER
     * @param User $user
     * @return array
     */
    public function updateUser(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return array('update' => true, 'msg' => self::MSG_UPDATE_VALID);
    }

    /**
     * RESET DU MDP
     * @param $token
     * @param $password
     * @return array
     */
    public function resetPassword($token, $password)
    {
        $user = $this->userRepository->findByKeyValue('resetToken', $token);

        if ($user === null) {
            return array('error' => true, 'msg' => self::MSG_INVALID_TOKEN);
        }

        $user->setResetToken(null);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return array('error' => false, 'msg' => self::MSG_PASSWORD_UPDATE);
    }

    /**
     * MAJ DU MDP
     * @param $user
     * @param $password
     * @return array
     */
    public function updatePassword(User $user, string $password)
    {
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return array('error' => false, 'msg' => self::MSG_PASSWORD_UPDATE);
    }

    /**
     * RENOUVELLEMENT MDP
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
            $this->notification->sendEmail($data['user'], self::MSG_FORGOTTEN_PSWD, $dataTemplate);

            return array('msg' => self::MSG_EMAIL_SEND);
        }

        return array('msg' => self::MSG_EMAIL_ERROR);
    }
}
