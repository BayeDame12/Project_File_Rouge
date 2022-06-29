<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FriteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FriteRepository::class)]
#[ApiResource]
class Frite extends Produit
{

    #[ORM\Column(type: 'string', length: 255)]
    private $portionFrite;

    public function getPortionFrite(): ?string
    {
        return $this->portionFrite;
    }

    public function setPortionFrite(string $portionFrite): self
    {
        $this->portionFrite = $portionFrite;

        return $this;
    }
}
