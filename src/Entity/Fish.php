<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FishRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(denormalizationContext: ['groups' => ['fish:write']], security: 'is_granted("ROLE_USER")'),
        new Get(
            uriTemplate: '/fish/{id}',
            security: 'is_granted("ROLE_USER")',
            normalizationContext: ['groups' => ['fish:read']],
            name: 'get_fish'
        ),
        new Delete(security: 'is_granted("ROLE_USER")'),
    ],
    normalizationContext: ['groups' => ['fish:read']],
    denormalizationContext: ['groups' => ['fish:create', 'fish:update']],
)]



#[ORM\Entity(repositoryClass: FishRepository::class)]
#[ORM\Table(name: 'fish')]
class Fish
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['fish:read'])]
    private ?int $id = null;

    #[Assert\NotBlank(groups: ['fish:create'])]
    #[ORM\Column(length: 255)]
    #[Groups(['fish:read', 'fish:write'])]
    private ?string $url = null;

    #[Assert\NotBlank(groups: ['fish:create'])]
    #[ORM\Column]
    #[Groups(['fish:read', 'fish:write'])]
    private ?int $size = null;

    #[Assert\NotBlank(groups: ['fish:create'])]
    #[ORM\Column]
    #[Groups(['fish:read', 'fish:write'])]
    private ?int $weight = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }
}
