<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
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
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=50)
     */
    private $subject;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=20)
     */
    private $phone;

    /**
     * @Assert\Length(min=50)
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Appartment")
     * @ORM\JoinColumn(name="appartment_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $appartment;

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
     * @param  string email
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Permet de récupérer le sujet
     * @return string subject
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * Permet de setter le sujet
     * @param  string subject
     * @return self
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Permet de récupérer le téléphone
     * @return string phone
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Permet de setter le phone
     * @param  string phone
     * @return self
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Permet de récupérer le texte
     * @return string text
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * Permet de setter le texte
     * @param  string text
     * @return self
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Permet de récupérer la date
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
     * Permet de récupérer l'appartment
     * @return Appartment appartment
     */
    public function getAppartment(): ?Appartment
    {
        return $this->appartment;
    }

    /**
     * Permet de setter l'appartment
     * @param  Appartment appartment
     * @return self
     */
    public function setAppartment(?Appartment $appartment): self
    {
        $this->appartment = $appartment;

        return $this;
    }

    /**
     * Override toString
     * @return string subject
     */
    public function __toString() {
      return $this->subject;
    }
}
