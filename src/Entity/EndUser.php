<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EndUserRepository")
 */
class EndUser implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"list_users", "user_details_route"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user_details_route")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user_details_route")
     */
    private $fistname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"list_users", "user_details_route"})
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="enduser")
     */
    private $client;

    public function __toString(): ?string
    {
    }

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
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getFistname()
    {
        return $this->fistname;
    }

    /**
     * @param mixed $fistname
     */
    public function setFistname($fistname): void
    {
        $this->fistname = $fistname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client): void
    {
        $this->client = $client;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {



        return ;
    }
}
