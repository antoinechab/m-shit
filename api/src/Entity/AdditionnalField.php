<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AdditionnalFieldRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AdditionnalFieldRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['additionnal_field:read']],
    denormalizationContext: ['groups' => ['additionnal_field:write']]
)]
class AdditionnalField
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['contact:read', 'additionnal_field:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contact:read', 'contact:write', 'additionnal_field:read', 'additionnal_field:write'])]
    private ?string $label = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contact:read', 'contact:write', 'additionnal_field:read', 'additionnal_field:write'])]
    private ?string $field = null;

    #[ORM\ManyToOne(inversedBy: 'additionnalFields')]
    #[Groups(['additionnal_field:read', 'additionnal_field:write'])]
    private ?Contact $contact = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getField(): ?string
    {
        return $this->field;
    }

    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}
