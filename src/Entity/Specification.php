<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecificationRepository")
 */
class Specification
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $screen_diagonal;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $screen_resolution;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type_of_screen;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $processor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ram;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $internal_memory;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $memory_card;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $photo_sensor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $front_photo_sensor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $battery_capacity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $operating_system;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $nfc;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $dual_sim;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $network;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $other = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScreenDiagonal(): ?int
    {
        return $this->screen_diagonal;
    }

    public function setScreenDiagonal(?int $screen_diagonal): self
    {
        $this->screen_diagonal = $screen_diagonal;

        return $this;
    }

    public function getScreenResolution(): ?int
    {
        return $this->screen_resolution;
    }

    public function setScreenResolution(): ?string
    {
        return $this->screen_resolution;
    }

    public function getTypeOfScreen(): ?string
    {
        return $this->type_of_screen;
    }

    public function setTypeOfScreen(?string $type_of_screen): self
    {
        $this->type_of_screen = $type_of_screen;

        return $this;
    }

    public function getProcessor(): ?string
    {
        return $this->processor;
    }

    public function setProcessor(?string $processor): self
    {
        $this->processor = $processor;

        return $this;
    }

    public function getRam(): ?int
    {
        return $this->ram;
    }

    public function setRam(?int $ram): self
    {
        $this->ram = $ram;

        return $this;
    }

    public function getInternalMemory(): ?int
    {
        return $this->internal_memory;
    }

    public function setInternalMemory(?int $internal_memory): self
    {
        $this->internal_memory = $internal_memory;

        return $this;
    }

    public function getMemoryCard(): ?bool
    {
        return $this->memory_card;
    }

    public function setMemoryCard(?bool $memory_card): self
    {
        $this->memory_card = $memory_card;

        return $this;
    }

    public function getPhotoSensor(): ?int
    {
        return $this->photo_sensor;
    }

    public function setPhotoSensor(?int $photo_sensor): self
    {
        $this->photo_sensor = $photo_sensor;

        return $this;
    }

    public function getFrontPhotoSensor(): ?int
    {
        return $this->front_photo_sensor;
    }

    public function setFrontPhotoSensor(?int $front_photo_sensor): self
    {
        $this->front_photo_sensor = $front_photo_sensor;

        return $this;
    }

    public function getBatteryCapacity(): ?int
    {
        return $this->battery_capacity;
    }

    public function setBatteryCapacity(?int $battery_capacity): self
    {
        $this->battery_capacity = $battery_capacity;

        return $this;
    }

    public function getOperatingSystem(): ?string
    {
        return $this->operating_system;
    }

    public function setOperatingSystem(?string $operating_system): self
    {
        $this->operating_system = $operating_system;

        return $this;
    }

    public function getNfc(): ?bool
    {
        return $this->nfc;
    }

    public function setNfc(?bool $nfc): self
    {
        $this->nfc = $nfc;

        return $this;
    }

    public function getDualSim(): ?bool
    {
        return $this->dual_sim;
    }

    public function setDualSim(?bool $dual_sim): self
    {
        $this->dual_sim = $dual_sim;

        return $this;
    }

    public function getNetwork(): ?string
    {
        return $this->network;
    }

    public function setNetwork(?string $network): self
    {
        $this->network = $network;

        return $this;
    }

    public function getOther(): ?array
    {
        return $this->other;
    }

    public function setOther(?array $other): self
    {
        $this->other = $other;

        return $this;
    }
}
