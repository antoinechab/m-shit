<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Controller\FileUploadController;
use App\Repository\AvatarRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

//'post' => [
//    'method' => 'POST',
//    'controller' => FileUploadController::class,
//    'deserialize' => false,
//    'input_formats' => [
//        'multipart' => ['multipart/form-data'],
//    ],
//],


#[ORM\Entity(repositoryClass: AvatarRepository::class)]
#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new Get(),
        new Post(
            inputFormats: [
                'multipart' => 'multipart/form-data',
            ],
            controller: FileUploadController::class,
            deserialize: false
        ),
        new Post(
            uriTemplate: '/avatar/{id}/file',
            inputFormats: [
                'multipart' => 'multipart/form-data'
            ],
            controller: FileUploadController::class,
            denormalizationContext: [
                'groups' => 'avatar:file'
            ],
            deserialize: false,
            name: "post_image",
        ),
        new Delete()
    ],
    normalizationContext: ['groups' => ['avatar:read']],
    denormalizationContext: ['groups' => ['avatar:write']]
)]
class Avatar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['avatar:read', 'contact:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['avatar:read', 'contact:read'])]
    private ?string $contentUrl = null;

    #[Vich\UploadableField("post_files", "path")]
    #[Groups(['avatar:write','avatar:file'])]
    public ?File $file = null;

    #[ORM\OneToOne(mappedBy: 'avatar', cascade: ['persist', 'remove'])]
    #[Groups(['avatar:write'])]
    private ?Contact $contact = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentUrl(): ?string
    {
        return $this->contentUrl;
    }

    public function setContentUrl(string $contentUrl): self
    {
        $this->contentUrl = $contentUrl;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @param File|null $file
     */
    public function setFile(?File $file): void
    {
        $this->file = $file;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        // unset the owning side of the relation if necessary
        if ($contact === null && $this->contact !== null) {
            $this->contact->setAvatar(null);
        }

        // set the owning side of the relation if necessary
        if ($contact !== null && $contact->getAvatar() !== $this) {
            $contact->setAvatar($this);
        }

        $this->contact = $contact;

        return $this;
    }
}
