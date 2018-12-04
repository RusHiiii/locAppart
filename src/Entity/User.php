<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
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
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $firstname;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lastname;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="json")
     */
    private $role = [];

    /**
     * Permet de récupérer l'id
     * @return int id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Permet de récupérer l'email
     * @return string email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Permet de setter l'email
     * @param  string $email
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Permet de récupérer le prenom
     * @return string firstname
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Permet de setter le prénom
     * @param  string firstname
     * @return self
     */
    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Permet de récupérere le lastname
     * @return string lastname
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * Permet de setter le lastname
     * @param  string lastname
     * @return self
     */
    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Permet de récupérer le password
     * @return string password
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Permet de setter le password
     * @param  string password
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Permet de récuéper la date
     * @return DateTimeInterface date
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * Permet de setter la date
     * @param  DateTimeInterface date
     * @return self
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Permet de récupérer le genre
     * @return string gender
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * Permet de setter le genre
     * @param  string gender
     * @return self
     */
    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Permet de récupérer le role
     * @return json role
     */
    public function getRole(): ?array
    {
        return $this->role;
    }

    /**
     * Permet de setter le role
     * @param  array role
     * @return self
     */
    public function setRole(array $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Override toString
     * @return string email
     */
    public function __toString()
    {
        return $this->email;
    }
}
