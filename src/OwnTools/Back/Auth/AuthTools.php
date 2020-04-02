<?php
/**
 * Create by maxime
 * Date 4/2/2020
 * Time 11:06 AM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : AuthTools.php as AuthTools
 */

namespace App\OwnTools\Back\Auth;


use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuthTools
{
    /** @var TokenStorageInterface */
    private $storage;

    /**
     * AuthTools constructor.
     * @param TokenStorageInterface $storage
     */
    public function __construct(TokenStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @return bool
     */
    public function isUserNotConnected(): bool
    {
        return $this->storage->getToken()->getUser() === null;
    }
}