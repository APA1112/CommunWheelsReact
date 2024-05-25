<?php

// src/Entity/Trip.php

namespace App\Entity;

use App\Repository\TripRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TripRepository::class)]
class Trip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $tripDate = null;

    #[ORM\Column]
    private ?int $entrySlot = null;

    #[ORM\Column]
    private ?int $exitSlot = null;

    #[ORM\ManyToOne(inversedBy: 'trips')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TimeTable $timeTable = null;

    #[ORM\ManyToOne(inversedBy: 'trips')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Driver $driver = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTripDate(): ?\DateTime
    {
        return $this->tripDate;
    }

    public function setTripDate(?\DateTime $tripDate): Trip
    {
        $this->tripDate = $tripDate;
        return $this;
    }

    public function getEntrySlot(): ?int
    {
        return $this->entrySlot;
    }

    public function setEntrySlot(?int $entrySlot): Trip
    {
        $this->entrySlot = $entrySlot;
        return $this;
    }

    public function getExitSlot(): ?int
    {
        return $this->exitSlot;
    }

    public function setExitSlot(?int $exitSlot): Trip
    {
        $this->exitSlot = $exitSlot;
        return $this;
    }

    public function getTimeTable(): ?TimeTable
    {
        return $this->timeTable;
    }

    public function setTimeTable(?TimeTable $timeTable): static
    {
        $this->timeTable = $timeTable;
        return $this;
    }

    public function getDriver(): ?Driver
    {
        return $this->driver;
    }

    public function setDriver(?Driver $driver): static
    {
        $this->driver = $driver;
        return $this;
    }
}

