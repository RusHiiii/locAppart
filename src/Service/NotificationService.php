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
    private $userRepository;
    private $passwordEncoder;
    private $entityManager;
    private $mailer;
    private $tokenGenerator;
    private $router;

    public function __construct(
    UserRepository $userRepo,
    UserPasswordEncoderInterface $passwordEncoder,
    EntityManagerInterface $entityManager,
    \Swift_Mailer $mailer,
    TokenGeneratorInterface $tokenGenerator,
    RouterInterface $router
  ) {
        $this->userRepository = $userRepo;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        $this->tokenGenerator = $tokenGenerator;
        $this->router = $router;
    }

    /**
     * Permet de générer un token
     * @param  string email
     * @return array
     */
    public function generateToken($email)
    {
        $user = $this->userRepository->findByKeyValue('email', $email);

        if ($user === null) {
            return array('token' => false, 'msg' => 'Email Inconnu');
        }

        $token = $this->tokenGenerator->generateToken();

        try {
            $user->setResetToken($token);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return array('token' => false, 'msg' => $e->getMessage());
        }

        $url = $this->router->generate('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

        return array('token' => true, 'msg' => $url, 'user' => $user);
    }

    /**
     * Permet d'envoyer un mail
     * @param  User user
     * @param  string subject
     * @param  string message
     * @return array
     */
    public function sendEmail($user, $subject, $message)
    {
        $message = (new \Swift_Message($subject))
        ->setFrom('webmaster@gmail.com')
        ->setTo($user->getEmail())
        ->setBody(
            $message,
            'text/html'
        );

        $this->mailer->send($message);

        return array('send' => true, 'msg' =>'Mail envoyé');
    }
}
