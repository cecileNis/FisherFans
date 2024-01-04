<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(
            denormalizationContext: ['groups' => ['reservation:create']], security: "is_granted('ROLE_USER')"
        ),
        new Get(normalizationContext: ['groups' => ['reservation:read', 'reservation:inspect']]),
        new Get(
            uriTemplate: '/reservation/{id}',
            normalizationContext: ['groups' => ['reservation:read']],
            security: "is_granted('ROLE_USER')",
            name: 'reservation_info'
        ),
       new Delete(security: "is_granted('ROLE_ADMIN') or object.owner == user"),
       new Put(
            denormalizationContext: ['groups' => ['reservation:create']], security: "object.owner == user",
            uriTemplate: '/reservation/{id}/update'
        )
    ],
    normalizationContext: ['groups' => ['reservation:read']],
    denormalizationContext: ['groups' => ['reservation:create', 'reservation:update']],
)]
#[ORM\Table(name: '`reservation`')]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['reservation:read'])]
    private ?int $id = null;
    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['reservation:create', 'reservation:read'])]
    #[Assert\NotBlank(groups: ['reservation:create'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    #[Groups(['reservation:create', 'reservation:read'])]
    #[Assert\NotBlank(groups: ['reservation:create'])]
    private ?int $passagerSeat = null;

    #[ORM\Column]
    #[Groups(['reservation:create', 'reservation:read'])]
    #[Assert\NotBlank(groups: ['reservation:create'])]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[Groups(['reservation:read'])]
    private ?User $owner = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[Groups(['reservation:read'])]
    private ?Outing $outing = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getPassagerSeat(): ?int
    {
        return $this->passagerSeat;
    }

    public function setPassagerSeat(int $passager_seat): static
    {
        $this->passagerSeat = $passager_seat;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

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

    public function getOuting(): ?Outing
    {
        return $this->outing;
    }

    public function setOuting(?Outing $outing): static
    {
        $this->outing = $outing;

        return $this;
    }
}
