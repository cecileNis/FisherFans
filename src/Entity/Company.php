<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Post;

#[ORM\Table(name: '`company`')]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['company:read']]),
        new Post(denormalizationContext: ['groups' => ['company:create']], security: "is_granted('ROLE_USER')"),
        new Get(normalizationContext: ['groups' => ['company:read']]),
    ],
)]
#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[Groups(['company:read'])]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(groups: ['company:create'])]
    #[Groups(['company:read', 'company:create'])]
    #[ORM\Column(length: 255)]
    private ?string $siret = null;

    #[Assert\NotBlank(groups: ['company:create'])]
    #[Groups(['company:read', 'company:create'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Assert\NotBlank(groups: ['company:create'])]
    #[Groups(['company:read', 'company:create'])]
    #[ORM\Column(length: 255)]
    private ?string $typeOfActivity = null;

    #[Assert\NotBlank(groups: ['company:create'])]
    #[Groups(['company:read', 'company:create'])]
    #[ORM\Column(length: 255)]
    private ?string $rc = null;

    #[ORM\OneToOne(mappedBy: 'company', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): static
    {
        $this->siret = $siret;

        return $this;
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

    public function getTypeOfActivity(): ?string
    {
        return $this->typeOfActivity;
    }

    public function setTypeOfActivity(string $typeOfActivity): static
    {
        $this->typeOfActivity = $typeOfActivity;

        return $this;
    }

    public function getRc(): ?string
    {
        return $this->rc;
    }

    public function setRc(string $rc): static
    {
        $this->rc = $rc;

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
            $this->user->setCompany(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getCompany() !== $this) {
            $user->setCompany($this);
        }

        $this->user = $user;

        return $this;
    }
}
