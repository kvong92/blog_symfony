<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\Column(length: 255)]
    private ?string $summary = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $published_date = null;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'posts')]
    private Collection $tag_id;

    public function __construct()
    {
        $this->tag_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): static
    {
        $this->summary = $summary;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getPublishedDate(): ?\DateTimeInterface
    {
        return $this->published_date;
    }

    public function setPublishedDate(\DateTimeInterface $published_date): static
    {
        $this->published_date = $published_date;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTagId(): Collection
    {
        return $this->tag_id;
    }

    public function addTagId(Tag $tagId): static
    {
        if (!$this->tag_id->contains($tagId)) {
            $this->tag_id->add($tagId);
        }

        return $this;
    }

    public function removeTagId(Tag $tagId): static
    {
        $this->tag_id->removeElement($tagId);

        return $this;
    }
}
