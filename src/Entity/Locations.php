<?php

namespace App\Entity;

use App\Repository\LocationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocationsRepository::class)
 */
class Locations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Prestations::class, inversedBy="locations")
     */
    private $prestation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img;

    public function __construct()
    {
        $this->prestation = new ArrayCollection();
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
     * @return Collection<int, Prestations>
     */
    public function getPrestation(): Collection
    {
        return $this->prestation;
    }

    public function addPrestation(Prestations $prestation): self
    {
        if (!$this->prestation->contains($prestation)) {
            $this->prestation[] = $prestation;
        }

        return $this;
    }

    public function removePrestation(Prestations $prestation): self
    {
        $this->prestation->removeElement($prestation);

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }
}
