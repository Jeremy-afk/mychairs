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

    #[ORM\ManyToOne(inversedBy: 'OneToMany')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Member $member = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'chairToStack', targetEntity: Chair::class)]
    private Collection $chairsInStack;


    public function __construct()
    {
        $this->relationToChair = new ArrayCollection();
        $this->chairsInStack = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this -> id = $id;
        return $this;
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

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): static
    {
        $this->member = $member;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Chair>
     */
    public function getChairsInStack(): Collection
    {
        return $this->chairsInStack;
    }

    public function addChairsInStack(Chair $chairsInStack): static
    {
        if (!$this->chairsInStack->contains($chairsInStack)) {
            $this->chairsInStack->add($chairsInStack);
            $chairsInStack->setChairToStack($this);
        }

        return $this;
    }

    public function removeChairsInStack(Chair $chairsInStack): static
    {
        if ($this->chairsInStack->removeElement($chairsInStack)) {
            // set the owning side to null (unless already changed)
            if ($chairsInStack->getChairToStack() === $this) {
                $chairsInStack->setChairToStack(null);
            }
        }

        return $this;
    }

}
