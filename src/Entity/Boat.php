<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\CreateBoatController;
use App\Controller\SearchBoatByCoordsController;
use App\Controller\SearchBoatFilterController;
use App\Repository\BoatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoatRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(
            controller: CreateBoatController::class,
            denormalizationContext: ['groups' => ['boat:create']], security: "is_granted('ROLE_USER')"
        ),
        new Get(
            uriTemplate: '/boat/{id}',
            normalizationContext: ['groups' => ['boat:read']],
            security: "is_granted('ROLE_USER')",
            name: 'boat_info'
        ),
        new GetCollection(
            uriTemplate: '/boats/filter/{filter}/{value}',
            controller: SearchBoatFilterController::class,
            normalizationContext: ['groups' => ['boat:read']],
            security: "is_granted('ROLE_USER')",
            name: 'boat_filter'
        ),
        new GetCollection(
            uriTemplate: '/boats/search/{x1}/{y1}/{x2}/{y2}',
            controller: SearchBoatByCoordsController::class,
            normalizationContext: ['groups' => ['boat:read']],
            security: "is_granted('ROLE_USER')",
            name: 'boat_search'
        ),
        new Delete(security: "is_granted('ROLE_ADMIN') or object.getOwner() == user"),
        new Put(
            denormalizationContext: ['groups' => ['boat:create']], security: "object.getOwner() == user",
            uriTemplate: '/boat/{id}/update'
        )
    ],
    normalizationContext: ['groups' => ['boat:read']],
    denormalizationContext: ['groups' => ['boat:create', 'boat:update']],
)]
#[ORM\Table(name: '`boat`')]
class Boat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['boat:create', 'boat:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['boat:create', 'boat:read'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['boat:create', 'boat:read'])]
    private ?string $brand = null;

    #[ORM\Column]
    #[Groups(['boat:create', 'boat:read'])]
    private ?int $yearOfFabrication = null;

    #[ORM\Column(length: 255)]
    #[Groups(['boat:create', 'boat:read'])]
    private ?string $licence = null;

    #[ORM\Column(length: 255)]
    #[Groups(['boat:create', 'boat:read'])]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    #[Groups(['boat:create', 'boat:read'])]
    private ?string $equipment = null;

    #[ORM\Column]
    #[Groups(['boat:create', 'boat:read'])]
    private ?int $caution = null;

    #[ORM\Column]
    #[Groups(['boat:create', 'boat:read'])]
    private ?int $capacity = null;

    #[ORM\Column]
    #[Groups(['boat:create', 'boat:read'])]
    private ?int $numberOfBeds = null;

    #[ORM\Column(length: 255)]
    #[Groups(['boat:create', 'boat:read'])]
    private ?string $coords = null;

    #[ORM\Column(length: 255)]
    #[Groups(['boat:create', 'boat:read'])]
    private ?string $motorization = null;

    #[ORM\Column(length: 255)]
    #[Groups(['boat:create', 'boat:read'])]
    private ?string $power = null;

    #[ORM\ManyToOne(inversedBy: 'boats')]
    private ?Port $port = null;

    #[ORM\ManyToOne(inversedBy: 'boats')]
    private ?User $owner = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getYearOfFabrication(): ?int
    {
        return $this->yearOfFabrication;
    }

    public function setYearOfFabrication(int $yearOfFabrication): static
    {
        $this->yearOfFabrication = $yearOfFabrication;

        return $this;
    }

    public function getLicence(): ?string
    {
        return $this->licence;
    }

    public function setLicence(string $licence): static
    {
        $this->licence = $licence;

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

    public function getEquipment(): ?string
    {
        return $this->equipment;
    }

    public function setEquipment(string $equipment): static
    {
        $this->equipment = $equipment;

        return $this;
    }

    public function getCaution(): ?int
    {
        return $this->caution;
    }

    public function setCaution(int $caution): static
    {
        $this->caution = $caution;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getNumberOfBeds(): ?int
    {
        return $this->numberOfBeds;
    }

    public function setNumberOfBeds(int $numberOfBeds): static
    {
        $this->numberOfBeds = $numberOfBeds;

        return $this;
    }

    public function getCoords(): ?string
    {
        return $this->coords;
    }

    public function setCoords(string $coords): static
    {
        $this->coords = $coords;

        return $this;
    }

    public function getMotorization(): ?string
    {
        return $this->motorization;
    }

    public function setMotorization(string $motorization): static
    {
        $this->motorization = $motorization;

        return $this;
    }

    public function getPower(): ?string
    {
        return $this->power;
    }

    public function setPower(string $power): static
    {
        $this->power = $power;

        return $this;
    }

    public function getPort(): ?Port
    {
        return $this->port;
    }

    public function setPort(?Port $port): static
    {
        $this->port = $port;

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
}
