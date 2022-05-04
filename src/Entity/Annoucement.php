<?php

namespace App\Entity;

use App\Repository\AnnoucementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnoucementRepository::class)]
class Annoucement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\Column(type: 'text', nullable: true)]
    private $picture;

    #[ORM\ManyToOne(targetEntity: Car::class, inversedBy: 'annoucements')]
    #[ORM\JoinColumn(nullable: false)]
    private $concerne;

    #[ORM\OneToMany(mappedBy: 'annoucement', targetEntity: Favorite::class)]
    private $adding;

    public function __construct()
    {
        $this->adding = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getConcerne(): ?Car
    {
        return $this->concerne;
    }

    public function setConcerne(?Car $concerne): self
    {
        $this->concerne = $concerne;

        return $this;
    }

    /**
     * @return Collection<int, Favorite>
     */
    public function getAdding(): Collection
    {
        return $this->adding;
    }

    public function addAdding(Favorite $adding): self
    {
        if (!$this->adding->contains($adding)) {
            $this->adding[] = $adding;
            $adding->setAnnoucement($this);
        }

        return $this;
    }

    public function removeAdding(Favorite $adding): self
    {
        if ($this->adding->removeElement($adding)) {
            // set the owning side to null (unless already changed)
            if ($adding->getAnnoucement() === $this) {
                $adding->setAnnoucement(null);
            }
        }

        return $this;
    }
}
