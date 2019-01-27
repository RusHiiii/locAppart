<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class NotificationService
{
    const MSG_EMAIL_NOT_FOUND = 'Email inconnu';
    const MSG_EMAIL_SEND      = 'Email envoyé !';

    private $userRepository;
    private $passwordEncoder;
    private $entityManager;
    private $mailer;
    private $tokenGenerator;
    private $router;
    private $templating;

    public function __construct(
    UserRepository $userRepo,
    UserPasswordEncoderInterface $passwordEncoder,
    EntityManagerInterface $entityManager,
    \Swift_Mailer $mailer,
    TokenGeneratorInterface $tokenGenerator,
    RouterInterface $router,
    \Twig_Environment $templating
  ) {
        $this->userRepository = $userRepo;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        $this->tokenGenerator = $tokenGenerator;
        $this->router = $router;
        $this->templating = $templating;
    }

    /**
     * GENERATION DE TOKEN
     * @param $email
     * @return array
     */
    public function generateToken($email)
    {
        $user = $this->userRepository->findByKeyValue('email', $email);

        if ($user === null) {
            return [
                'token' => false,
                'msg' => self::MSG_EMAIL_NOT_FOUND
            ];
        }

        $token = $this->tokenGenerator->generateToken();

        try {
            $user->setResetToken($token);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return [
                'token' => false,
                'msg' => $e->getMessage()
            ];
        }

        $url = $this->router->generate('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

        return [
            'token' => true,
            'msg' => $url,
            'user' => $user
        ];
    }

    /**
     * ENVOIE DU MAIL
     * @param $user
     * @param $subject
     * @param $message
     * @return array
     */
    public function sendEmail(array $users, $subject, $message)
    {
        $mails = $this->formatMailFromUsers($users);

        $message = (new \Swift_Message($subject))
          ->setFrom('webmaster@gmail.com')
          ->setTo($mails)
          ->setBody(
              $message,
              'text/html'
          );

        $this->mailer->send($message);

        return [
            'send' => true,
            'msg' => self::MSG_EMAIL_SEND
        ];
    }

    private function formatMailFromUsers(array $users)
    {
        $mails = [];

        foreach ($users as $user){
            $mails[] = $user->getEmail();
        }

        return $mails;
    }
}
