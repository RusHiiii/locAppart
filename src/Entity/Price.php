<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PriceRepository")
 */
class Price
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\LessThan(propertyPath="dateEnd", message = "La date n'est pas valide")
     * @ORM\Column(type="date")
     */
    private $dateBegin;

    /**
     * @Assert\GreaterThan(propertyPath="dateBegin", message = "La date n'est pas valide")
     * @ORM\Column(type="date")
     */
    private $dateEnd;

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(value = 20, message = "Le prix est incorrect")
     * @ORM\Column(type="float")
     */
    private $price;


    /**
     * @Assert\NotBlank(
     *     message = "Spécifiez une valeur."
     * )
     * @ORM\ManyToOne(targetEntity="App\Entity\Availability")
     * @ORM\JoinColumn(name="availability_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $availability;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Appartment", inversedBy="prices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $appartment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateBegin(): ?\DateTimeInterface
    {
        return $this->dateBegin;
    }

    public function setDateBegin(\DateTimeInterface $dateBegin): self
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAvailability(): ?Availability
    {
        return $this->availability;
    }

    public function setAvailability(Availability $availability): self
    {
        $this->availability = $availability;

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
