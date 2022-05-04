<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $model;

    #[ORM\Column(type: 'string', length: 255)]
    private $brand;

    #[ORM\Column(type: 'date')]
    private $releaseYear;



    #[ORM\Column(type: 'string', length: 255)]
    private $fuel;

    #[ORM\Column(type: 'boolean')]
    private $driverLicense;

    #[ORM\OneToMany(mappedBy: 'concerne', targetEntity: Annoucement::class)]
    private $annoucements;

    public function __construct()
    {
        $this->annoucements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getReleaseYear(): ?\DateTimeInterface
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(\DateTimeInterface $releaseYear): self
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(int $km): self
    {
        $this->km = $km;

        return $this;
    }

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel(string $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getDriverLicense(): ?bool
    {
        return $this->driverLicense;
    }

    public function setDriverLicense(bool $driverLicense): self
    {
        $this->driverLicense = $driverLicense;

        return $this;
    }

    /**
     * @return Collection<int, Annoucement>
     */
    public function getAnnoucements(): Collection
    {
        return $this->annoucements;
    }

    public function addAnnoucement(Annoucement $annoucement): self
    {
        if (!$this->annoucements->contains($annoucement)) {
            $this->annoucements[] = $annoucement;
            $annoucement->setConcerne($this);
        }

        return $this;
    }

    public function removeAnnoucement(Annoucement $annoucement): self
    {
        if ($this->annoucements->removeElement($annoucement)) {
            // set the owning side to null (unless already changed)
            if ($annoucement->getConcerne() === $this) {
                $annoucement->setConcerne(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->model;
    }
}
