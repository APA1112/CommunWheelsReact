<?php

namespace App\Entity;

use App\Repository\DriverRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DriverRepository::class)]
class Driver
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'El nombre es obligatorio')]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Los apellidos son obligatorios')]
    #[Assert\Length(min: 2, max: 255)]
    
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'El email es obligatorio')]
    #[Assert\Email()]
    private ?string $email = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:'El numero de asientos libres es obligatorio')]
    #[Assert\Range(
        min: 0,
        max: 6,
        notInRangeMessage: 'El número de asientos libres debe estar entre {{ min }} y {{ max }}',
    )]
    private ?int $seats = null;

    #[ORM\Column]
    private ?int $daysDriven = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message:'El timepo de espera es obligatorio')]
    #[Assert\Range(
        min: 0,
        max: 2,
        notInRangeMessage: 'El timepo de espera debe estar entre {{ min }} y {{ max }}',
    )]
    private ?int $waitTime = null;

    #[ORM\ManyToMany(targetEntity: Group::class, mappedBy: 'drivers')]
    private Collection $groupCollection;

    #[ORM\OneToMany(mappedBy: 'driver', targetEntity: Absence::class, orphanRemoval: true)]
    private Collection $absences;

    #[ORM\OneToMany(mappedBy: 'driver', targetEntity: Schedule::class, orphanRemoval: true)]
    private Collection $schedules;

    #[ORM\OneToOne(mappedBy: 'driver', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->groupCollection = new ArrayCollection();
        $this->absences = new ArrayCollection();
        $this->schedules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Driver
    {
        $this->name = $name;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): Driver
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): Driver
    {
        $this->email = $email;
        return $this;
    }

    public function getSeats(): ?int
    {
        return $this->seats;
    }

    public function setSeats(?int $seats): Driver
    {
        $this->seats = $seats;
        return $this;
    }

    public function getDaysDriven(): ?int
    {
        return $this->daysDriven;
    }

    public function setDaysDriven(?int $daysDriven): Driver
    {
        $this->daysDriven = $daysDriven;
        return $this;
    }

    public function getWaitTime(): ?int
    {
        return $this->waitTime;
    }

    public function setWaitTime(?int $waitTime): Driver
    {
        $this->waitTime = $waitTime;
        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getGroupCollection(): Collection
    {
        return $this->groupCollection;
    }

    public function addGroupCollection(Group $groupCollection): static
    {
        if (!$this->groupCollection->contains($groupCollection)) {
            $this->groupCollection->add($groupCollection);
        }

        return $this;
    }

    public function removeGroupCollection(Group $groupCollection): static
    {
        $this->groupCollection->removeElement($groupCollection);

        return $this;
    }

    /**
     * @return Collection<int, Absence>
     */
    public function getAbsences(): Collection
    {
        return $this->absences;
    }

    public function addAbsence(Absence $absence): static
    {
        if (!$this->absences->contains($absence)) {
            $this->absences->add($absence);
            $absence->setDriver($this);
        }

        return $this;
    }

    public function removeAbsence(Absence $absence): static
    {
        if ($this->absences->removeElement($absence)) {
            // set the owning side to null (unless already changed)
            if ($absence->getDriver() === $this) {
                $absence->setDriver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Schedule>
     */
    public function getSchedules(): Collection
    {
        return $this->schedules;
    }

    public function addSchedule(Schedule $schedule): static
    {
        if (!$this->schedules->contains($schedule)) {
            $this->schedules->add($schedule);
            $schedule->setDriver($this);
        }

        return $this;
    }

    public function removeSchedule(Schedule $schedule): static
    {
        if ($this->schedules->removeElement($schedule)) {
            // set the owning side to null (unless already changed)
            if ($schedule->getDriver() === $this) {
                $schedule->setDriver(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName() .' '.  $this->getLastName();
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

}
