<?php

namespace App\Entity;

use App\Repository\FormulesRepository;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass=FormulesRepository::class)
 */
class Formules
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Prestations::class, inversedBy="formules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $relation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pdf;

    /**
     * @Vich\UploadableField(mapping="my_pdf_files", fileNameProperty="pdf")
     * @Assert\NotBlank(message="Please upload a PDF file.")
     * @Assert\File(mimeTypes={"application/pdf"})
     */
    
   
     private $pdfFile;


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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getRelation(): ?Prestations
    {
        return $this->relation;
    }

    public function setRelation(?Prestations $relation): self
    {
        $this->relation = $relation;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getPdf(): ?string
    {
         
    return $this->pdf;

    }

    public function setPdf(?string $pdf): self
    {
        
        $this->pdf = $pdf; 
        return $this;
    }

    public function getPdfFile(): ?File
    {
        return $this->pdfFile ? new File($this->pdfFile) : null;
    }

    public function setPdfFile(?File $pdfFile = null): self
    {
        $this->pdfFile = $pdfFile;

        return $this;

    }

}
