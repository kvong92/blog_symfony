<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Post::class, mappedBy: 'tags')]
    private Collection $Posts;

    public function __construct()
    {
        $this->Posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->Posts;
    }
    public function addPost(Post $post): self
    {
        if (!$this->Posts->contains($post)) {
            $this->Posts->add($post);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        $this->Posts->removeElement($post);

        return $this;
    }

    public function __toString()
    {
        return $this->name; // This will display the tag name in association fields
    }
}
