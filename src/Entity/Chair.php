<?php

namespace App\Entity;

use App\Repository\ChairRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChairRepository::class)]
class Chair
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $rarity = null;

    #[ORM\Column]
    private ?int $nbLegs = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'chairsInStack')]
    private ?Stack $chairToStack = null;

    #[ORM\ManyToMany(targetEntity: Lounge::class, mappedBy: 'manytomany')]
    private Collection $lounges;
/*
    #[ORM\ManyToOne(inversedBy: 'OneToMany')]getStack
*/
    public function __construct()
    {
        $this->relationToStack = new ArrayCollection();
        $this->chairToStacks = new ArrayCollection();
        $this->lounges = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getRarity(): ?string
    {
        return $this->rarity;
    }

    public function setRarity(string $rarity): static
    {
        $this->rarity = $rarity;

        return $this;
    }

    public function getNbLegs(): ?int
    {
        return $this->nbLegs;
    }

    public function setNbLegs(int $nbLegs): static
    {
        $this->nbLegs = $nbLegs;

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

    public function getStack(): ?Stack
    {
        return $this->stack;
    }

    public function setStack(Stack $stack): static
    {
        $this->stack = $stack;

        return $this;
    }

    public function getChairToStack(): ?Stack
    {
        return $this->chairToStack;
    }

    public function setChairToStack(?Stack $chairToStack): static
    {
        $this->chairToStack = $chairToStack;

        return $this;
    }

    /**
     * @return Collection<int, Lounge>
     */
    public function getLounges(): Collection
    {
        return $this->lounges;
    }

    public function addLounge(Lounge $lounge): static
    {
        if (!$this->lounges->contains($lounge)) {
            $this->lounges->add($lounge);
            $lounge->addManytomany($this);
        }

        return $this;
    }

    public function removeLounge(Lounge $lounge): static
    {
        if ($this->lounges->removeElement($lounge)) {
            $lounge->removeManytomany($this);
        }

        return $this;
    }

}
