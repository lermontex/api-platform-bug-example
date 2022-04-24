<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\GraphQl\Mutation;
use ApiPlatform\Metadata\Link;
use App\Repository\DomainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity(repositoryClass: DomainRepository::class)]
#[ORM\Table(name: "domains")]
#[ApiResource(
    uriVariables: [
        'userId' => new Link(fromProperty: 'domains', fromClass: User::class),
        'id' => new Link(fromClass: self::class, identifiers: ['id'])
    ],
    normalizationContext: ['groups' => ['domain:read_normalization']]
)]
#[GetCollection(uriTemplate: '/users/{userId}/domains.{_format}')]
#[Get(uriTemplate: '/users/{userId}/domains/{id}.{_format}')]
#[Mutation(
    denormalizationContext: ['groups' => ['domain:update_denormalization'], 'disable_type_enforcement' => true],
    name: 'update'
)]
#[Mutation(
    denormalizationContext: ['groups' => ['domain:update_denormalization'], 'disable_type_enforcement' => true],
    name: 'update2'
)]
class Domain
{
    #[ORM\Id]
    #[ORM\Column(type: "ulid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UlidGenerator::class)]
    #[ApiProperty(identifier: true)]
    #[Groups(['domain:read_normalization'])]
    private Ulid $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "domains")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['domain:read_normalization'])]
    private ?User $user = null;

    #[ORM\Column(type: "string", length: 255, nullable: false)]
    #[Groups(['domain:update_denormalization', 'domain:read_normalization'])]
    private ?string $apiToken = null;

    #[ORM\Column(type: "boolean")]
    #[Groups(['domain:update_denormalization', 'domain:read_normalization'])]
    private bool $isActive = false;

    #[ORM\OneToMany(mappedBy: "user", targetEntity: Domain::class, orphanRemoval: true)]
    #[Groups(['domain:read_normalization'])]
    private iterable $resetTokenRequests;

    public function __construct()
    {
        $this->resetTokenRequests = new ArrayCollection();
    }

    public function getId(): Ulid
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(?string $apiToken): self
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getResetApiTokenRequests(): iterable
    {
        return $this->resetTokenRequests;
    }

    public function addResetTokenRequest(ResetTokenRequest $resetTokenRequest): self
    {
        if (!$this->resetTokenRequests->contains($resetTokenRequest)) {
            $this->resetTokenRequests[] = $resetTokenRequest;
            $resetTokenRequest->setDomain($this);
        }

        return $this;
    }

    public function removeResetTokenRequest(ResetTokenRequest $resetTokenRequest): self
    {
        if ($this->resetTokenRequests->removeElement($resetTokenRequest)) {
            // set the owning side to null (unless already changed)
            if ($resetTokenRequest->getDomain() === $this) {
                $resetTokenRequest->setDomain(null);
            }
        }

        return $this;
    }
}
