<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeRepository")
 */
class Type
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(min=10)
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * Permet de recuperer l'id
     * @return int id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Permet de récupérer le nom
     * @return string name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Peremt de setter le nom
     * @param  string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Override toString
     * @return string name
     */
    public function __toString()
    {
        return $this->name;
    }
}
