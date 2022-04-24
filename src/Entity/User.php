<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "users")]
#[ApiResource(normalizationContext: ['groups' => ['user:read_normalization']])]
#[GetCollection(uriTemplate: '/users.{_format}')]
#[Get(uriTemplate: '/users/{id}.{_format}')]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: "ulid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UlidGenerator::class)]
    #[ApiProperty(identifier: true)]
    #[Groups(['user:read_normalization'])]
    private Ulid $id;

    #[ORM\OneToMany(mappedBy: "user", targetEntity: Domain::class, orphanRemoval: true)]
    #[Groups(['user:read_normalization'])]
    private iterable $domains;

    public function __construct()
    {
        $this->domains = new ArrayCollection();
    }

    public function getId(): Ulid
    {
        return $this->id;
    }

    public function getDomains(): iterable
    {
        return $this->domains;
    }

    public function addDomain(Domain $domain): self
    {
        if (!$this->domains->contains($domain)) {
            $this->domains[] = $domain;
            $domain->setUser($this);
        }

        return $this;
    }

    public function removeDomain(Domain $domain): self
    {
        if ($this->domains->removeElement($domain)) {
            // set the owning side to null (unless already changed)
            if ($domain->getUser() === $this) {
                $domain->setUser(null);
            }
        }

        return $this;
    }
}
