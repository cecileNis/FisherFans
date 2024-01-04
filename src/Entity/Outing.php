<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\OutingRepository;
use App\Controller\CreateOutingController;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OutingRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(
            controller: CreateOutingController::class,
            denormalizationContext: ['groups' => ['outing:create']],
            security: "is_granted('ROLE_USER')",
        ),
        new Get(
            uriTemplate: '/outing/{id}',
            normalizationContext: ['groups' => ['outing:read']],
            security: "is_granted('ROLE_USER')",
            name: 'outing_info'
        ),
       new Delete(security: "is_granted('ROLE_ADMIN') or object.getOwner() == user"),
       new Put(
            denormalizationContext: ['groups' => ['outing:create']], security: "object.getOwner() == user",
            uriTemplate: '/outing/{id}/update'
        )
    ],
    normalizationContext: ['groups' => ['outing:read']],
    denormalizationContext: ['groups' => ['outing:create', 'outing:update']],
)]
#[ORM\Table(name: '`outing`')]
class Outing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['outing:create', 'outing:read'])]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Groups(['outing:create', 'outing:read'])]
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[Groups(['outing:create', 'outing:read'])]
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[Groups(['outing:create', 'outing:read'])]
    #[ORM\Column(length: 255)]
    private ?string $typeOfRate = null;

    #[Groups(['outing:create', 'outing:read'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateOfStart = null;

    #[Groups(['outing:create', 'outing:read'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateOfEnd = null;

    #[Groups(['outing:create', 'outing:read'])]
    #[ORM\Column]
    private ?int $passagerSeat = null;

    #[Groups(['outing:create', 'outing:read'])]
    #[ORM\Column]
    private ?int $rate = null;

    #[Groups(['outing:read'])]
    #[ORM\ManyToOne(inversedBy: 'outings')]
    private ?User $owner = null;

    #[Groups(['outing:read'])]
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
        return $this->typeOfRate;
    }

    public function setTypeOfRate(string $typeOfRate): static
    {
        $this->typeOfRate = $typeOfRate;

        return $this;
    }

    public function getDateOfStart(): ?\DateTimeInterface
    {
        return $this->dateOfStart;
    }

    public function setDateOfStart(\DateTimeInterface $dateOfStart): static
    {
        $this->dateOfStart = $dateOfStart;

        return $this;
    }

    public function getDateOfEnd(): ?\DateTimeInterface
    {
        return $this->dateOfEnd;
    }

    public function setDateOfEnd(\DateTimeInterface $dateOfEnd): static
    {
        $this->dateOfEnd = $dateOfEnd;

        return $this;
    }

    public function getPassagerSeat(): ?int
    {
        return $this->passagerSeat;
    }

    public function setPassagerSeat(int $passagerSeat): static
    {
        $this->passagerSeat = $passagerSeat;

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
