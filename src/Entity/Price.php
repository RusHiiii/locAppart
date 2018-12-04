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
     * @Assert\LessThan(propertyPath="dateMax")
     * @ORM\Column(type="date")
     */
    private $dateBegin;

    /**
     * @Assert\GreaterThan(propertyPath="dateMin")
     * @ORM\Column(type="date")
     */
    private $dateEnd;

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(10)
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=100)
     */
    private $availability;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Appartment", inversedBy="prices")
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
     * Permet de récupérer la date de début
     * @return DateTimeInterface dateBegin
     */
    public function getDateBegin(): ?\DateTimeInterface
    {
        return $this->dateBegin;
    }

    /**
     * Permet de setter la date de début
     * @param  DateTimeInterface dateBegin
     * @return self
     */
    public function setDateBegin(\DateTimeInterface $dateBegin): self
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    /**
     * Permet de récupérer la date de fin
     * @return DateTimeInterface dateEnd
     */
    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    /**
     * Permet de setter la date de fin
     * @param  DateTimeInterface dateEnd
     * @return self
     */
    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Permet de récupérer le prix
     * @return float price
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * Permet de setter le prix
     * @param  float price
     * @return self
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Permet de récupérer la disponibilité
     * @return string availability
     */
    public function getAvailability(): ?string
    {
        return $this->availability;
    }

    /**
     * Permet de setter la disponibilité
     * @param  string availability
     * @return self
     */
    public function setAvailability(string $availability): self
    {
        $this->availability = $availability;

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
