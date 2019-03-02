<?php

namespace App\Entity\WebApp;

use App\Entity\WebApp\City;
use App\Entity\WebApp\Message;
use App\Entity\WebApp\Price;
use App\Entity\WebApp\Ressource;
use App\Entity\WebApp\Status;
use App\Entity\WebApp\Type;
use App\Entity\WebApp\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WebApp\AppartmentRepository")
 * @ORM\Table(name="appartments")
 */
class Appartment
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
     * @ORM\Column(type="string", length=150)
     */
    private $title;

    /**
     * @Assert\Range(
     *      min = 5,
     *      max = 300,
     *      minMessage = "La surface doit être supérieur à {{ limit }} m²",
     *      maxMessage = "La surface doit être inférieur à {{ limit }} m²"
     * )
     * @Assert\NotBlank()
     * @ORM\Column(type="integer")
     */
    private $area;

    /**
     * @Assert\Range(
     *      min = 1,
     *      max = 15,
     *      minMessage = "Le nombre de pièce doit être supérieur à {{ limit }}",
     *      maxMessage = "Le nombre de pièce doit être inférieur à {{ limit }}"
     * )
     * @Assert\NotBlank()
     * @ORM\Column(type="integer")
     */
    private $room;

    /**
     * @Assert\Length(min=100)
     * @Assert\NotBlank()
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $people;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $bedroom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ski;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $information;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=5)
     * @ORM\Column(type="text")
     */
    private $adress;

    /**
     * @ORM\Column(type="float")
     */
    private $lat;

    /**
     * @ORM\Column(type="float")
     */
    private $lng;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $reference;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WebApp\Type")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WebApp\Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WebApp\City")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WebApp\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="App\Entity\WebApp\Ressource", mappedBy="appartment", orphanRemoval=true, cascade={"persist"})
     */
    private $ressources;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WebApp\Message", mappedBy="appartment", orphanRemoval=true)
     */
    private $messages;

    /**
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="App\Entity\WebApp\Price", mappedBy="appartment", orphanRemoval=true, cascade={"persist"})
     */
    private $prices;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $garage;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $locker;

    public function __construct()
    {
        $this->ressources = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->prices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getArea(): ?int
    {
        return $this->area;
    }

    public function setArea(int $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getRoom(): ?int
    {
        return $this->room;
    }

    public function setRoom(int $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPeople(): ?string
    {
        return $this->people;
    }

    public function setPeople(string $people): self
    {
        $this->people = $people;

        return $this;
    }

    public function getBedroom(): ?int
    {
        return $this->bedroom;
    }

    public function setBedroom(?int $bedroom): self
    {
        $this->bedroom = $bedroom;

        return $this;
    }

    public function getSki(): ?int
    {
        return $this->ski;
    }

    public function setSki(?int $ski): self
    {
        $this->ski = $ski;

        return $this;
    }

    public function getInformation(): ?string
    {
        return $this->information;
    }

    public function setInformation(?string $information): self
    {
        $this->information = $information;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRessources(): Collection
    {
        return $this->ressources;
    }

    public function addRessource(Ressource $ressource): self
    {
        if (!$this->ressources->contains($ressource)) {
            $this->ressources[] = $ressource;
            $ressource->setAppartment($this);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): self
    {
        if ($this->ressources->contains($ressource)) {
            $this->ressources->removeElement($ressource);
            // set the owning side to null (unless already changed)
            if ($ressource->getAppartment() === $this) {
                $ressource->setAppartment(null);
            }
        }

        return $this;
    }

    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setAppartment($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getAppartment() === $this) {
                $message->setAppartment(null);
            }
        }

        return $this;
    }

    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(Price $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
            $price->setAppartment($this);
        }

        return $this;
    }

    public function removePrice(Price $price): self
    {
        if ($this->prices->contains($price)) {
            $this->prices->removeElement($price);
            if ($price->getAppartment() === $this) {
                $price->setAppartment(null);
            }
        }

        return $this;
    }

    public function getGarage(): ?bool
    {
        return $this->garage;
    }

    public function setGarage(?bool $garage): self
    {
        $this->garage = $garage;

        return $this;
    }

    public function getLocker(): ?bool
    {
        return $this->locker;
    }

    public function setLocker(?bool $locker): self
    {
        $this->locker = $locker;

        return $this;
    }

    public function __toString()
    {
        return $this->reference;
    }
}
