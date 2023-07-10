<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
class Articles
{
    
    #[ORM\Id]
    #[ORM\Column(length: 500)]
    private ?string $référence = null;

    #[ORM\Column(length: 500)]
    private ?string $designation = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantités = null;

    #[ORM\Column(nullable: true)]
    private ?float $prix = null;


    public function getRéférence(): ?string
    {
        return $this->référence;
    }

    public function setRéférence(string $référence): static
    {
        $this->référence = $référence;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function getQuantités(): ?int
    {
        return $this->quantités;
    }

    public function setQuantités(?int $quantités): static
    {
        $this->quantités = $quantités;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }
}
