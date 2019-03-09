<?php

namespace App\Service\WebApp;

use App\Repository\WebApp\UserRepository;
use App\Entity\WebApp\User;
use App\Service\Tools\NotificationService;
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
    const MSG_GENERIC_ERROR  = 'Une erreur est survenue :(';

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
        $msg = self::MSG_REGISTER_VALID;

        $data = $this->templating->render('shared/email/register.html.twig', ['user' => $user]);
        $this->notification->sendEmail([$user], self::MSG_REGISTER_EMAIL, $data);

        $this->entityManager->persist($user);
        try{
            $this->entityManager->flush();
        }catch (\Exception $e){
            $msg = self::MSG_GENERIC_ERROR;
        }

        return [
            'msg' => $msg
        ];
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
        $msg = self::MSG_UPDATE_VALID;

        $this->entityManager->persist($user);
        try{
            $this->entityManager->flush();
        }catch (\Exception $e){
            $msg = self::MSG_GENERIC_ERROR;
        }

        return [
            'msg' => $msg
        ];
    }

    /**
     * RESET DU MDP
     * @param $token
     * @param $password
     * @return array
     */
    public function resetPassword($token, $password)
    {
        $msg = self::MSG_PASSWORD_UPDATE;

        $user = $this->userRepository->findByKeyValue('resetToken', $token);

        if ($user === null) {
            return [
                'msg' => self::MSG_INVALID_TOKEN
            ];
        }

        $user->setResetToken(null);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));

        $this->entityManager->persist($user);
        try{
            $this->entityManager->flush();
        }catch (\Exception $e){
            $msg = self::MSG_GENERIC_ERROR;
        }

        return [
            'msg' => $msg
        ];
    }

    /**
     * MAJ DU MDP
     * @param $user
     * @param $password
     * @return array
     */
    public function updatePassword(User $user, string $password)
    {
        $msg = self::MSG_PASSWORD_UPDATE;

        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));

        $this->entityManager->persist($user);
        try{
            $this->entityManager->flush();
        }catch (\Exception $e){
            $msg = self::MSG_GENERIC_ERROR;
        }

        return [
            'msg' => $msg
        ];
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
            $dataTemplate = $this->templating->render('shared/email/reset_password.html.twig', ['data' => $data['msg']]);
            $this->notification->sendEmail([$data['user']], self::MSG_FORGOTTEN_PSWD, $dataTemplate);

            return [
                'msg' => self::MSG_EMAIL_SEND
            ];
        }

        return [
            'msg' => self::MSG_EMAIL_ERROR
        ];
    }
}
