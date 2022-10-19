<?php

namespace App\Entity;

use App\Repository\CompraRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\Producto;

#[ORM\Entity(repositoryClass: CompraRepository::class)]
class Compra
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToMany(targetEntity: Producto::class)]
    private Collection $productoscomprados;

    public function __construct()
    {
        $this->productoscomprados = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * @return Collection<int, Producto>
     */
    public function getProductoscomprados(): Collection
    {
        return $this->productoscomprados;
    }

    public function addProductoscomprado(Producto $productoscomprado): self
    {
        if (!$this->productoscomprados->contains($productoscomprado)) {
            $this->productoscomprados->add($productoscomprado);
        }

        return $this;
    }

    public function removeProductoscomprado(Producto $productoscomprado): self
    {
        $this->productoscomprados->removeElement($productoscomprado);

        return $this;
    }


}
