<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $photos =[] ;

    /**
     * @ORM\ManyToOne(targetEntity=Realisations::class, inversedBy="photos")
     */
    private $realisationId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhotos(): ?array
    {
        return $this->photos;
    }

    public function setPhotos(array $photos): self
    {
        $this->photos = $photos;

        return $this;
    }

    public function getRealisationId(): ?Realisations
    {
        return $this->realisationId;
    }

    public function setRealisationId(?Realisations $realisationId): self
    {
        $this->realisationId = $realisationId;

        return $this;
    }
}
