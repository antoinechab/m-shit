<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
#[ApiResource(
    normalizationContext: ['groups' => ['group:read']],
    denormalizationContext: ['groups' => ['group:write']]
)]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['contact:read', 'group:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contact:read', 'group:read', 'group:write'])]
    private ?string $color = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contact:read', 'group:read', 'group:write'])]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'groups', targetEntity: Contact::class)]
    private Collection $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
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

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setGroups($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getGroups() === $this) {
                $contact->setGroups(null);
            }
        }

        return $this;
    }
}
