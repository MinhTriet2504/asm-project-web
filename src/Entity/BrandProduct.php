<?php

namespace App\Entity;

use App\Repository\BrandProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BrandProductRepository::class)
 */
class BrandProduct
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
    private $NameBrand;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameBrand(): ?string
    {
        return $this->NameBrand;
    }
    public function setNameBrand(string $NameBrand): self
    {
        $this->NameBrand = $NameBrand;

        return $this;
    }

    public function __toString() {
        return $this->NameBrand;
    }
}
