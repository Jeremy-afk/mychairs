<?php

namespace App\Entity;

use App\Repository\LoungeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoungeRepository::class)]
class Lounge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $published = null;

    #[ORM\ManyToMany(targetEntity: Chair::class, inversedBy: 'lounges')]
    private Collection $manytomany;

    #[ORM\ManyToOne(inversedBy: 'lounges')]
    private ?Member $creator = null;

    public function __construct()
    {
        $this->Creator = new ArrayCollection();
        $this->manytomany = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): static
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return Collection<int, Chair>
     */
    public function getManytomany(): Collection
    {
        return $this->manytomany;
    }

    public function addManytomany(Chair $manytomany): static
    {
        if (!$this->manytomany->contains($manytomany)) {
            $this->manytomany->add($manytomany);
        }

        return $this;
    }

    public function removeManytomany(Chair $manytomany): static
    {
        $this->manytomany->removeElement($manytomany);

        return $this;
    }

    public function getCreator(): ?Member
    {
        return $this->creator;
    }

    public function setCreator(?Member $creator): static
    {
        $this->creator = $creator;

        return $this;
    }
}
