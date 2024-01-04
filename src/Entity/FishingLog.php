<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FishingLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(denormalizationContext: ['groups' => ['fishing_log:write']]),
        new Get(
            uriTemplate: '/fishing_log/{id}',
            security: 'is_granted("ROLE_USER")',
            normalizationContext: ['groups' => ['fishing_log:read']],
            name: 'get_fishing_log'
        ),
        new Put(
            uriTemplate: '/fishing_log/{id}',
            security: 'is_granted("ROLE_USER")',
            normalizationContext: ['groups' => ['fishing_log:read']],
            denormalizationContext: ['groups' => ['fishing_log:update']],
            name: 'put_fishing_log'
        ),
        new Delete(security: 'is_granted("ROLE_USER")'),
    ],
    normalizationContext: ['groups' => ['fishing_log:read']],
    denormalizationContext: ['groups' => ['fishing_log:create', 'fishing_log:update']],
)]


#[ORM\Entity(repositoryClass: FishingLogRepository::class)]
#[ORM\Table(name: 'fishing_log')]
class FishingLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['fishing_log:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['fishing_log:read', 'fishing_log:write', 'fishing_log:update'])]
    private ?string $comment = null;

    #[ORM\Column(length: 255)]
    #[Groups(['fishing_log:read', 'fishing_log:write'])]
    private ?string $location = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['fishing_log:read', 'fishing_log:write'])]
    private ?\DateTimeInterface $dateOfFishing = null;

    #[ORM\Column]
    #[Groups(['fishing_log:read', 'fishing_log:write'])]
    private ?bool $released = null;

    #[ORM\ManyToOne(inversedBy: 'fishingLogs')]
    private ?User $owner = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Fish $fish = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getDateOfFishing(): ?\DateTimeInterface
    {
        return $this->dateOfFishing;
    }

    public function setDateOfFishing(\DateTimeInterface $dateOfFishing): static
    {
        $this->dateOfFishing = $dateOfFishing;

        return $this;
    }

    public function isReleased(): ?bool
    {
        return $this->released;
    }

    public function setReleased(bool $released): static
    {
        $this->released = $released;

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

    public function getFish(): ?Fish
    {
        return $this->fish;
    }

    public function setFish(?Fish $fish): static
    {
        $this->fish = $fish;

        return $this;
    }
}
