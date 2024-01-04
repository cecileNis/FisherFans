<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PortRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Annotation\Groups;


#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(denormalizationContext: ['groups' => ['port:create']], security: 'is_granted("ROLE_USER")'),
        new Get(
            security: 'is_granted("ROLE_USER")',
            normalizationContext: ['groups' => ['port:read']],
        ),
        new Delete(security: 'is_granted("ROLE_USER")'),
    ],
    normalizationContext: ['groups' => ['port:read']],
    denormalizationContext: ['groups' => ['port:create', 'port:update']],
)]

#[ORM\Entity(repositoryClass: PortRepository::class)]
#[ORM\Table(name: 'port')]
class Port
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['port:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['port:create', 'port:read', 'port:write'])]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Groups(['port:create', 'port:read', 'port:write'])]
    private ?string $country = null;

    #[ORM\OneToMany(mappedBy: 'port', targetEntity: Boat::class)]
    private Collection $boats;

    public function __construct()
    {
        $this->boats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, Boat>
     */
    public function getBoats(): Collection
    {
        return $this->boats;
    }

    public function addBoat(Boat $boat): static
    {
        if (!$this->boats->contains($boat)) {
            $this->boats->add($boat);
            $boat->setPort($this);
        }

        return $this;
    }

    public function removeBoat(Boat $boat): static
    {
        if ($this->boats->removeElement($boat)) {
            // set the owning side to null (unless already changed)
            if ($boat->getPort() === $this) {
                $boat->setPort(null);
            }
        }

        return $this;
    }
}
