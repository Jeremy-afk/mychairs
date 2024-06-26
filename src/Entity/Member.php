<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Stack::class, orphanRemoval: true)]
    private Collection $OneToMany;

    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: Lounge::class)]
    private Collection $lounges;

    #[ORM\OneToOne(mappedBy: 'member', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->OneToMany = new ArrayCollection();
        $this->lounges = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNom();
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
    
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Stack>
     */
    public function getOneToMany(): Collection
    {
        return $this->OneToMany;
    }

    public function addOneToMany(Stack $oneToMany): static
    {
        if (!$this->OneToMany->contains($oneToMany)) {
            $this->OneToMany->add($oneToMany);
            $oneToMany->setMember($this);
        }

        return $this;
    }

    public function removeOneToMany(Stack $oneToMany): static
    {
        if ($this->OneToMany->removeElement($oneToMany)) {
            // set the owning side to null (unless already changed)
            if ($oneToMany->getMember() === $this) {
                $oneToMany->setMember(null);
            }
        }

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
            $lounge->setCreator($this);
        }

        return $this;
    }

    public function removeLounge(Lounge $lounge): static
    {
        if ($this->lounges->removeElement($lounge)) {
            // set the owning side to null (unless already changed)
            if ($lounge->getCreator() === $this) {
                $lounge->setCreator(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setMember(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getMember() !== $this) {
            $user->setMember($this);
        }

        $this->user = $user;

        return $this;
    }

}
