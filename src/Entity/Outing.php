<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\OutingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OutingRepository::class)]
#[ApiResource]
class Outing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $type_of_rate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_of_start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_of_end = null;

    #[ORM\Column]
    private ?int $passager_seat = null;

    #[ORM\Column]
    private ?int $rate = null;

    #[ORM\ManyToOne(inversedBy: 'outings')]
    private ?User $owner = null;

    #[ORM\OneToMany(mappedBy: 'outing', targetEntity: Reservation::class)]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getTypeOfRate(): ?string
    {
        return $this->type_of_rate;
    }

    public function setTypeOfRate(string $type_of_rate): static
    {
        $this->type_of_rate = $type_of_rate;

        return $this;
    }

    public function getDateOfStart(): ?\DateTimeInterface
    {
        return $this->date_of_start;
    }

    public function setDateOfStart(\DateTimeInterface $date_of_start): static
    {
        $this->date_of_start = $date_of_start;

        return $this;
    }

    public function getDateOfEnd(): ?\DateTimeInterface
    {
        return $this->date_of_end;
    }

    public function setDateOfEnd(\DateTimeInterface $date_of_end): static
    {
        $this->date_of_end = $date_of_end;

        return $this;
    }

    public function getPassagerSeat(): ?int
    {
        return $this->passager_seat;
    }

    public function setPassagerSeat(int $passager_seat): static
    {
        $this->passager_seat = $passager_seat;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): static
    {
        $this->rate = $rate;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setOuting($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getOuting() === $this) {
                $reservation->setOuting(null);
            }
        }

        return $this;
    }
}
