<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RessourceRepository")
 */
class Ressource
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\File(
     *     maxSize = "1024k",
     *     mimeTypes = {"image/png", "image/jpg", "image/jpeg"},
     *     mimeTypesMessage = "Veuillez uploder une image valide"
     * )
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Appartment", inversedBy="ressources")
     * @ORM\JoinColumn(nullable=false)
     */
    private $appartment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getAppartment(): ?Appartment
    {
        return $this->appartment;
    }

    public function setAppartment(?Appartment $appartment): self
    {
        $this->appartment = $appartment;

        return $this;
    }

    public function __toString()
    {
        return $this->id;
    }
}
