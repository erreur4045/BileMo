<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firm;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EndUser", mappedBy="client")
     */
    private $enduser;

    public function __construct()
    {
        $this->enduser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirm(): ?string
    {
        return $this->firm;
    }

    public function setFirm(string $firm): self
    {
        $this->firm = $firm;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|EndUser[]
     */
    public function getEnduser(): Collection
    {
        return $this->enduser;
    }

    public function addEnduser(EndUser $enduser): self
    {
        if (!$this->enduser->contains($enduser)) {
            $this->enduser[] = $enduser;
            $enduser->setClient($this);
        }

        return $this;
    }

    public function removeEnduser(EndUser $enduser): self
    {
        if ($this->enduser->contains($enduser)) {
            $this->enduser->removeElement($enduser);
            // set the owning side to null (unless already changed)
            if ($enduser->getClient() === $this) {
                $enduser->setClient(null);
            }
        }

        return $this;
    }
}
