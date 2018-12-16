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
     * @Assert\NotBlank(
     *      message="Veuillez upload un fichier correct"
     * )
     * @Assert\File(
     *      mimeTypes={"image/png"}
     * )
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Appartment", inversedBy="ressources")
     * @ORM\JoinColumn(nullable=false)
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
     * Permet de récupérer le fichier
     * @return string file
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Permet de setter le fichier
     * @param  string file
     * @return self
     */
    public function setFile($file): self
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Permet de récupérer un appartment
     * @return Appartment appartment
     */
    public function getAppartment(): ?Appartment
    {
        return $this->appartment;
    }

    /**
     * Permet de setter un appartment
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
     * @return string id
     */
    public function __toString()
    {
        return $this->id;
    }
}
