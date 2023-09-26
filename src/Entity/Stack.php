<?php

namespace App\Entity;

use App\Repository\StackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StackRepository::class)]
class Stack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isPublic = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'relationToStack', targetEntity: Chair::class)]
    private Collection $relationToChair;

    public function __construct()
    {
        $this->relationToChair = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): static
    {
        $this->isPublic = $isPublic;

        return $this;
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

    /**
     * @return Collection<int, Chair>
     */
    public function getRelationToChair(): Collection
    {
        return $this->relationToChair;
    }

    public function addRelationToChair(Chair $relationToChair): static
    {
        if (!$this->relationToChair->contains($relationToChair)) {
            $this->relationToChair->add($relationToChair);
            $relationToChair->setRelationToStack($this);
        }

        return $this;
    }

    public function removeRelationToChair(Chair $relationToChair): static
    {
        if ($this->relationToChair->removeElement($relationToChair)) {
            // set the owning side to null (unless already changed)
            if ($relationToChair->getRelationToStack() === $this) {
                $relationToChair->setRelationToStack(null);
            }
        }

        return $this;
    }
}
