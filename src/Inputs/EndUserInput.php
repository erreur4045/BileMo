<?php

/**
 * Create by maxime
 * Date 2/12/2020
 * Time 11:23 AM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : EnduserInput.php as EnduserInput
 */

namespace App\Entity\Inputs;

use App\Entity\Client;

class EndUserInput
{
    /** @var string */
        private $lastname;
    /** @var string */
        private $firstname;
    /** @var string */
        private $email;
    /** @var Client */
        private $client;
    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }
}
