<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['contact:read']],
    denormalizationContext: ['groups' => ['contact:write']]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'firstName' => 'ipartial',
    'lastName' => 'ipartial',
    'phoneNumber' => 'ipartial',
    'email' => 'ipartial',
    'additionnalFields.label' => 'ipartial',
    'additionnalFields.field' => 'ipartial',
    'groups.label' => 'ipartial',
    'groups.color' => 'ipartial'
])]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['contact:read', 'additionnal_field:read', 'avatar:write', 'additionnal_field:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contact:read', 'contact:write'])]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contact:read', 'contact:write'])]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contact:read', 'contact:write'])]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contact:read', 'contact:write'])]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'contacts')]
    #[Groups(['contact:read'])]
    private ?Group $groups = null;

    #[ORM\OneToMany(mappedBy: 'contact', targetEntity: AdditionnalField::class)]
    #[Groups(['contact:read'])]
    private Collection $additionnalFields;

    #[ORM\OneToOne(inversedBy: 'contact', cascade: ['persist', 'remove'])]
    #[Groups(['contact:read'])]
    private ?Avatar $avatar = null;

    public function __construct()
    {
        $this->additionnalFields = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getGroups(): ?Group
    {
        return $this->groups;
    }

    public function setGroups(?Group $groups): self
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * @return Collection<int, AdditionnalField>
     */
    public function getAdditionnalFields(): Collection
    {
        return $this->additionnalFields;
    }

    public function addAdditionnalField(AdditionnalField $additionnalField): self
    {
        if (!$this->additionnalFields->contains($additionnalField)) {
            $this->additionnalFields->add($additionnalField);
            $additionnalField->setContact($this);
        }

        return $this;
    }

    public function removeAdditionnalField(AdditionnalField $additionnalField): self
    {
        if ($this->additionnalFields->removeElement($additionnalField)) {
            // set the owning side to null (unless already changed)
            if ($additionnalField->getContact() === $this) {
                $additionnalField->setContact(null);
            }
        }

        return $this;
    }

    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
    }

    public function setAvatar(?Avatar $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }
}
