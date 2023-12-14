<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AddressRepository;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Post;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\PostAddressController;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: '`address`')]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['address:read']]),
        new Post(denormalizationContext: ['groups' => ['address:create']], security: "is_granted('ROLE_USER')"),
        new Get(normalizationContext: ['groups' => ['address:read']]),
    ],
)]
#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[Groups(['address:read'])]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(groups: ['address:create'])]
    #[Groups(['address:read', 'address:create'])]
    #[ORM\Column(length: 255)]
    private ?string $street = null;

    #[Assert\NotBlank(groups: ['address:create'])]
    #[Groups(['address:read', 'address:create'])]
    #[ORM\Column(length: 255)]
    private ?string $numberOfStreet = null;

    #[Assert\NotBlank(groups: ['address:create'])]
    #[Groups(['address:read', 'address:create'])]
    #[ORM\Column(length: 255)]
    private ?string $zip = null;

    #[Assert\NotBlank(groups: ['address:create'])]
    #[Groups(['address:read', 'address:create'])]
    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\OneToOne(mappedBy: 'address', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getNumberOfStreet(): ?string
    {
        return $this->numberOfStreet;
    }

    public function setNumberOfStreet(string $numberOfStreet): static
    {
        $this->numberOfStreet = $numberOfStreet;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): static
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setAddress(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getAddress() !== $this) {
            $user->setAddress($this);
        }

        $this->user = $user;

        return $this;
    }
}
