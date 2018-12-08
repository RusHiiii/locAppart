<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas valide.",
     *     checkMX = true
     * )

     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @Assert\Regex(
     *  pattern="/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$/",
     *  message="Le mot de passe doit contenir 6 caractères ou plus avec un nombre, une majuscule, une minuscule et un caractère spécial."
     * )
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=2)
     * @ORM\Column(type="string", length=100)
     */
    private $firstname;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=2)
     * @ORM\Column(type="string", length=100)
     */
    private $lastname;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $gender;

    /**
     * Permet de récupérér l'id
     * @return int id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Permet de récupérer l'eamil
     * @return string email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Permet de setter l'eamil
     * @param  string email
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Permet de setter les roles
     * @param  array roles
     * @return self
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    /**
     * Permet de setter le pswd
     * @param  string password
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Recupere le firstname
     * @return string firstname
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Permet de setter le firstname
     * @param  string firstname
     * @return self
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Getter lastname
     * @return string lastname
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * Setter lastname
     * @param  string lastname
     * @return self
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Getter date
     * @return DateTimeInterface date
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * Setter date
     * @param  DateTimeInterface date
     * @return self
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Getter gender
     * @return string gender
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * Setter gender
     * @param  string gender
     * @return self
     */
    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }
}
