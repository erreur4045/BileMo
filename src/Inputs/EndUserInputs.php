<?php
/**
 * Create by maxime
 * Date 2/16/2020
 * Time 8:56 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : EndUserInputs.php as EndUserInputs
 */

namespace App\Inputs;


use App\Entity\Client;
use Symfony\Component\Validator\Constraints as Assert;
class EndUserInputs
{
    /**
     * @var string|null
     * @Assert\NotBlank()
     */
    private $lastname;
    /**
     * @var string|null
     * @Assert\NotBlank()
     */
    private $fistname;
    /**
     * @var string|null
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string|null $lastname
     */
    public function setLastname(?string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string|null
     */
    public function getFistname(): ?string
    {
        return $this->fistname;
    }

    /**
     * @param string|null $fistname
     */
    public function setFistname(?string $fistname): void
    {
        $this->fistname = $fistname;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}