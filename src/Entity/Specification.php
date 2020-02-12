<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @Groups("phone_details_route")
     */
    private $screendiagonal;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups("phone_details_route")
     */
    private $screenresolution;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("phone_details_route")
     */
    private $typeofscreen;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("phone_details_route")
     */
    private $processor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("phone_details_route")
     */
    private $ram;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("phone_details_route")
     */
    private $internalmemory;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("phone_details_route")
     */
    private $memorycard;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("phone_details_route")
     */
    private $photosensor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("phone_details_route")
     */
    private $frontphotosensor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("phone_details_route")
     */
    private $batterycapacity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("phone_details_route")
     */
    private $operatingsystem;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("phone_details_route")
     */
    private $nfc;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("phone_details_route")
     */
    private $dualsim;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups("phone_details_route")
     */
    private $network;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Groups("phone_details_route")
     */
    private $other = [];

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getScreendiagonal()
    {
        return $this->screendiagonal;
    }

    /**
     * @param mixed $screendiagonal
     */
    public function setScreendiagonal($screendiagonal): void
    {
        $this->screendiagonal = $screendiagonal;
    }

    /**
     * @return mixed
     */
    public function getScreenresolution()
    {
        return $this->screenresolution;
    }

    /**
     * @param mixed $screenresolution
     */
    public function setScreenresolution($screenresolution): void
    {
        $this->screenresolution = $screenresolution;
    }

    /**
     * @return mixed
     */
    public function getTypeofscreen()
    {
        return $this->typeofscreen;
    }

    /**
     * @param mixed $typeofscreen
     */
    public function setTypeofscreen($typeofscreen): void
    {
        $this->typeofscreen = $typeofscreen;
    }

    /**
     * @return mixed
     */
    public function getProcessor()
    {
        return $this->processor;
    }

    /**
     * @param mixed $processor
     */
    public function setProcessor($processor): void
    {
        $this->processor = $processor;
    }

    /**
     * @return mixed
     */
    public function getRam()
    {
        return $this->ram;
    }

    /**
     * @param mixed $ram
     */
    public function setRam($ram): void
    {
        $this->ram = $ram;
    }

    /**
     * @return mixed
     */
    public function getInternalmemory()
    {
        return $this->internalmemory;
    }

    /**
     * @param mixed $internalmemory
     */
    public function setInternalmemory($internalmemory): void
    {
        $this->internalmemory = $internalmemory;
    }

    /**
     * @return mixed
     */
    public function getMemorycard()
    {
        return $this->memorycard;
    }

    /**
     * @param mixed $memorycard
     */
    public function setMemorycard($memorycard): void
    {
        $this->memorycard = $memorycard;
    }

    /**
     * @return mixed
     */
    public function getPhotosensor()
    {
        return $this->photosensor;
    }

    /**
     * @param mixed $photosensor
     */
    public function setPhotosensor($photosensor): void
    {
        $this->photosensor = $photosensor;
    }

    /**
     * @return mixed
     */
    public function getFrontphotosensor()
    {
        return $this->frontphotosensor;
    }

    /**
     * @param mixed $frontphotosensor
     */
    public function setFrontphotosensor($frontphotosensor): void
    {
        $this->frontphotosensor = $frontphotosensor;
    }

    /**
     * @return mixed
     */
    public function getBatterycapacity()
    {
        return $this->batterycapacity;
    }

    /**
     * @param mixed $batterycapacity
     */
    public function setBatterycapacity($batterycapacity): void
    {
        $this->batterycapacity = $batterycapacity;
    }

    /**
     * @return mixed
     */
    public function getOperatingsystem()
    {
        return $this->operatingsystem;
    }

    /**
     * @param mixed $operatingsystem
     */
    public function setOperatingsystem($operatingsystem): void
    {
        $this->operatingsystem = $operatingsystem;
    }

    /**
     * @return mixed
     */
    public function getNfc()
    {
        return $this->nfc;
    }

    /**
     * @param mixed $nfc
     */
    public function setNfc($nfc): void
    {
        $this->nfc = $nfc;
    }

    /**
     * @return mixed
     */
    public function getDualsim()
    {
        return $this->dualsim;
    }

    /**
     * @param mixed $dualsim
     */
    public function setDualsim($dualsim): void
    {
        $this->dualsim = $dualsim;
    }

    /**
     * @return mixed
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * @param mixed $network
     */
    public function setNetwork($network): void
    {
        $this->network = $network;
    }

    /**
     * @return array
     */
    public function getOther(): array
    {
        return $this->other;
    }

    /**
     * @param array $other
     */
    public function setOther(array $other): void
    {
        $this->other = $other;
    }
}
