<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BoatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoatRepository::class)]
#[ApiResource]
class Boat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $marque = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_of_fabrication = null;

    #[ORM\Column(length: 255)]
    private ?string $licence = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $equipment = null;

    #[ORM\Column]
    private ?int $caution = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\Column]
    private ?int $number_of_beds = null;

    #[ORM\Column(length: 255)]
    private ?string $details = null;

    #[ORM\Column(length: 255)]
    private ?string $motorization = null;

    #[ORM\Column(length: 255)]
    private ?string $power = null;

    #[ORM\ManyToOne(inversedBy: 'boats')]
    private ?Port $port = null;

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

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getDateOfFabrication(): ?\DateTimeInterface
    {
        return $this->date_of_fabrication;
    }

    public function setDateOfFabrication(\DateTimeInterface $date_of_fabrication): static
    {
        $this->date_of_fabrication = $date_of_fabrication;

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
        return $this->number_of_beds;
    }

    public function setNumberOfBeds(int $number_of_beds): static
    {
        $this->number_of_beds = $number_of_beds;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): static
    {
        $this->details = $details;

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
}
