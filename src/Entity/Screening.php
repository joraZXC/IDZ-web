<?php

namespace App\Entity;

use App\Repository\ScreeningRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScreeningRepository::class)]
class Screening
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'screeningTime')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Movie $movie = null;

    #[ORM\Column]
    private ?int $hallNumber = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column]
    private ?int $availableSeats = null;

    /**
     * @var Collection<int, Ticket>
     */
    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'screening', orphanRemoval: true)]
    private Collection $customerName;

    public function __construct()
    {
        $this->customerName = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): static
    {
        $this->movie = $movie;

        return $this;
    }

    public function getHallNumber(): ?int
    {
        return $this->hallNumber;
    }

    public function setHallNumber(int $hallNumber): static
    {
        $this->hallNumber = $hallNumber;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getAvailableSeats(): ?int
    {
        return $this->availableSeats;
    }

    public function setAvailableSeats(int $availableSeats): static
    {
        $this->availableSeats = $availableSeats;

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getCustomerName(): Collection
    {
        return $this->customerName;
    }

    public function addCustomerName(Ticket $customerName): static
    {
        if (!$this->customerName->contains($customerName)) {
            $this->customerName->add($customerName);
            $customerName->setScreening($this);
        }

        return $this;
    }

    public function removeCustomerName(Ticket $customerName): static
    {
        if ($this->customerName->removeElement($customerName)) {
            if ($customerName->getScreening() === $this) {
                $customerName->setScreening(null);
            }
        }

        return $this;
    }
}