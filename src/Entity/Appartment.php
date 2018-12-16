<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AppartmentRepository")
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
     * @ORM\Column(type="string", length=20)
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
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=30)
     */
    private $reference;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ressource", mappedBy="appartment", orphanRemoval=true, cascade={"persist"})
     */
    private $ressources;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="appartment", orphanRemoval=true)
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Price", mappedBy="appartment", orphanRemoval=true)
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

    /**
     * Permet de récupérer l'id
     * @return int id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Permet de récupérer le titre
     * @return string title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Permet de setter le titre
     * @param  string title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Permet de récupérer la surface
     * @return int area
     */
    public function getArea(): ?int
    {
        return $this->area;
    }

    /**
     * Permet de setter la surface
     * @param  int  area
     * @return self
     */
    public function setArea(int $area): self
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Permet de récupérer le nb de piece
     * @return int room
     */
    public function getRoom(): ?int
    {
        return $this->room;
    }

    /**
     * Permet de setter le nb de piece
     * @param  int  room
     * @return self
     */
    public function setRoom(int $room): self
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Permet de récupérer la description
     * @return string description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Permet de setter la description
     * @param  string description
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Permet de récupérer le nb de personne
     * @return string people
     */
    public function getPeople(): ?string
    {
        return $this->people;
    }

    /**
     * Permet de setter le nb de personne
     * @param  string people
     * @return self
     */
    public function setPeople(string $people): self
    {
        $this->people = $people;

        return $this;
    }

    /**
     * Permet de récupérer le nb de chambre
     * @return int bedroom
     */
    public function getBedroom(): ?int
    {
        return $this->bedroom;
    }

    /**
     * Permet de setter le nb de chambre
     * @param  int bedroom
     * @return self
     */
    public function setBedroom(?int $bedroom): self
    {
        $this->bedroom = $bedroom;

        return $this;
    }

    /**
     * Permet de récupérer la distance des pistes
     * @return int ski
     */
    public function getSki(): ?int
    {
        return $this->ski;
    }

    /**
     * Permet de setter la distance des pistes
     * @param  int ski
     * @return self
     */
    public function setSki(?int $ski): self
    {
        $this->ski = $ski;

        return $this;
    }

    /**
     * Permet de récupérer les autres infos
     * @return string information
     */
    public function getInformation(): ?string
    {
        return $this->information;
    }

    /**
     * Permet de setter les infos
     * @param  string information
     * @return self
     */
    public function setInformation(?string $information): self
    {
        $this->information = $information;

        return $this;
    }

    /**
     * Permet de récupérer l'addresse
     * @return string adress
     */
    public function getAdress(): ?string
    {
        return $this->adress;
    }

    /**
     * Permet de setter l'adress
     * @param  string adress
     * @return self
     */
    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Permet de récupérer la latitude
     * @return float lat
     */
    public function getLat(): ?float
    {
        return $this->lat;
    }

    /**
     * Permet de setter la latitude
     * @param  float lat
     * @return self
     */
    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Permet de récupérer la longitude
     * @return float lng
     */
    public function getLng(): ?float
    {
        return $this->lng;
    }

    /**
     * Permet de setter la longitude
     * @param  float lng
     * @return self
     */
    public function setLng(float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Permet de récupérer la réferenece
     * @return string reference
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * Permet de setter la ref
     * @param  string reference
     * @return self
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;

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
     * Permet de récupérer le type
     * @return Type type
     */
    public function getType(): ?Type
    {
        return $this->type;
    }

    /**
     * Permet de setter le type
     * @param  Type type
     * @return self
     */
    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Permet de récupérer le status
     * @return Status status
     */
    public function getStatus(): ?Status
    {
        return $this->status;
    }

    /**
     * Permet de setter le status
     * @param  Status status
     * @return self
     */
    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Permet de récupérer la ville
     * @return City city
     */
    public function getCity(): ?City
    {
        return $this->city;
    }

    /**
     * Permet de récupérer la ville
     * @param  City city
     * @return self
     */
    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Permet de récuperer le user
     * @return User user
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Permet de setter le user
     * @param  User user
     * @return self
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Ressource[]
     */
    public function getRessources(): Collection
    {
        return $this->ressources;
    }

    /**
     * Permet d'ajouter une ressource
     * @param  Ressource ressource
     * @return self
     */
    public function addRessource(Ressource $ressource): self
    {
        if (!$this->ressources->contains($ressource)) {
            $this->ressources[] = $ressource;
            $ressource->setAppartment($this);
        }

        return $this;
    }

    /**
     * Permet la suppression d'une ressource
     * @param  Ressource ressource
     * @return self
     */
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

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    /**
     * Permet d'ajouter un message
     * @param  Message message
     * @return self
     */
    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setAppartment($this);
        }

        return $this;
    }

    /**
     * Permet de supprimer un message
     * @param  Message message
     * @return self
     */
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

    /**
     * @return Collection|Price[]
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    /**
     * Permet d'ajouter un prix
     * @param  Price price
     * @return self
     */
    public function addPrice(Price $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
            $price->setAppartment($this);
        }

        return $this;
    }

    /**
     * Permet de supprimer un prix
     * @param  Price price
     * @return self
     */
    public function removePrice(Price $price): self
    {
        if ($this->prices->contains($price)) {
            $this->prices->removeElement($price);
            // set the owning side to null (unless already changed)
            if ($price->getAppartment() === $this) {
                $price->setAppartment(null);
            }
        }

        return $this;
    }

    /**
     * Permet de récupérer le garage
     * @return bool garage
     */
    public function getGarage(): ?bool
    {
        return $this->garage;
    }

    /**
     * Permet de setter le garage
     * @param  bool garage
     * @return self
     */
    public function setGarage(?bool $garage): self
    {
        $this->garage = $garage;

        return $this;
    }

    /**
     * Permet de récupérer le casier
     * @return bool locker
     */
    public function getLocker(): ?bool
    {
        return $this->locker;
    }

    /**
     * Permet de setter le casier
     * @param  bool locker
     * @return self
     */
    public function setLocker(?bool $locker): self
    {
        $this->locker = $locker;

        return $this;
    }

    /**
     * Override toString
     * @return string reference
     */
    public function __toString()
    {
        return $this->reference;
    }
}
