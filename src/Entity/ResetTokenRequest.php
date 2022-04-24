<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Repository\ResetTokenRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity(repositoryClass: ResetTokenRequestRepository::class)]
#[ORM\Table(name: "reset_token_requests")]
#[ApiResource(
    uriVariables: [
        'userId' => new Link(fromProperty: 'domains', fromClass: User::class),
        'domainId' => new Link(fromProperty: 'resetTokenRequests', fromClass: Domain::class),
        'id' => new Link(fromClass: self::class, identifiers: ['id'])
    ],
    normalizationContext: ['groups' => ['reset_token_request:read_normalization']]
)]
#[GetCollection(uriTemplate: '/users/{userId}/domains/{domainId}/reset_token_requests.{_format}')]
#[Get(uriTemplate: '/users/{userId}/domains/{domainId}/reset_token_requests/{id}.{_format}')]
class ResetTokenRequest
{
    #[ORM\Id]
    #[ORM\Column(type: "ulid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UlidGenerator::class)]
    #[ApiProperty(identifier: true)]
    #[Groups(['reset_token_request:read_normalization'])]
    private Ulid $id;

    #[ORM\ManyToOne(targetEntity: Domain::class, inversedBy: "domains")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['reset_token_request:read_normalization'])]
    private ?Domain $domain = null;

    public function getId(): Ulid
    {
        return $this->id;
    }

    public function getDomain(): ?Domain
    {
        return $this->domain;
    }

    public function setDomain(?Domain $domain): self
    {
        $this->domain = $domain;

        return $this;
    }
}
