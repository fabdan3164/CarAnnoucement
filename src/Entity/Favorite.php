<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
class Favorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Annoucement::class, inversedBy: 'adding')]
    #[ORM\JoinColumn(nullable: false)]
    private $annoucement;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'favorites')]
    #[ORM\JoinColumn(nullable: false)]
    private $belong;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnoucement(): ?Annoucement
    {
        return $this->annoucement;
    }

    public function setAnnoucement(?Annoucement $annoucement): self
    {
        $this->annoucement = $annoucement;

        return $this;
    }

    public function getBelong(): ?User
    {
        return $this->belong;
    }

    public function setBelong(?User $belong): self
    {
        $this->belong = $belong;

        return $this;
    }
}
