<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'customerName')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Screening $screening = null;

    #[ORM\Column(length: 100)]
    private ?string $customerEmail = null;

    #[ORM\Column]
    private ?int $seatsCount = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $bookingTime = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $totalPrice = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScreening(): ?Screening
    {
        return $this->screening;
    }

    public function setScreening(?Screening $screening): static
    {
        $this->screening = $screening;

        return $this;
    }

    public function getCustomerEmail(): ?string
    {
        return $this->customerEmail;
    }

    public function setCustomerEmail(string $customerEmail): static
    {
        $this->customerEmail = $customerEmail;

        return $this;
    }

    public function getSeatsCount(): ?int
    {
        return $this->seatsCount;
    }

    public function setSeatsCount(int $seatsCount): static
    {
        $this->seatsCount = $seatsCount;

        return $this;
    }

    public function getBookingTime(): ?\DateTime
    {
        return $this->bookingTime;
    }

    public function setBookingTime(\DateTime $bookingTime): static
    {
        $this->bookingTime = $bookingTime;

        return $this;
    }

    public function getTotalPrice(): ?string
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(string $totalPrice): static
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }
}