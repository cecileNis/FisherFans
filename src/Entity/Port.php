<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PortRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortRepository::class)]
#[ApiResource]
class Port
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
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
