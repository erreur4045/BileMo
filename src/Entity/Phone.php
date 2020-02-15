<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhoneRepository")
 */
class Phone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("phone_list")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"phone_details_route", "phone_list"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"phone_details_route", "phone_list"})
     */
    private $weight;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"phone_details_route", "phone_list"})
     */
    private $height;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"phone_details_route", "phone_list"})
     */
    private $width;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"phone_details_route", "phone_list"})
     */
    private $depth;

    /**
     * @ORM\Column(type="integer")
     * @Groups("phone_list")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Supplier", inversedBy="phones")
     * @Groups({"phone_details_route", "phone_list"})
     */
    private $supplier;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Specification")
     * @Groups("phone_details_route")
     */
    private $specification;

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

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getDepth(): ?int
    {
        return $this->depth;
    }

    public function setDepth(int $depth): self
    {
        $this->depth = $depth;

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): self
    {
        $this->supplier = $supplier;

        return $this;
    }

    public function getSpecification(): ?Specification
    {
        return $this->specification;
    }

    public function setSpecification(?Specification $specification): self
    {
        $this->specification = $specification;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
