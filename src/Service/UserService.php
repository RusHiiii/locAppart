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

    public function __construct(
    UserRepository $userRepo,
    UserPasswordEncoderInterface $passwordEncoder,
    EntityManagerInterface $entityManager
  ) {
        $this->userRepository = $userRepo;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    /**
     * Permet d'enregistrer un user
     * @param  User   user
     * @return [type]
     */
    public function registerUser(User $user)
    {
        $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);
        $user->setEmail($user->getEmail());
        $user->setFirstname($user->getFirstname());
        $user->setLastname($user->getLastname());
        $user->setDate(new \DateTime('now'));
        $user->setGender($user->getGender());
        $user->setRoles(['ROLE_USER']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * Permet de reset un mot de passe
     * @param string token
     * @param string password
     */
    public function resetPassword($token, $password)
    {
        $user = $this->userRepository->findByKeyValue('resetToken', $token);

        if ($user === null) {
            return array('error' => true, 'msg' => 'Token Inconnu');
        }

        $user->setResetToken(null);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password['first']));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return array('error' => false, 'msg' => 'Mot de passe mis à jour');
    }
}
