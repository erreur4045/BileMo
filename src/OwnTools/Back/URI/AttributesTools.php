<?php
/**
 * Create by maxime
 * Date 4/2/2020
 * Time 10:49 AM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : AttributesTools.php as AttributesTools
 */

namespace App\OwnTools\Back\URI;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class AttributesTools
{
    /**
     * @param Request $request
     * @param UserInterface $client
     * @return bool
     */
    public function isClientLegitimate(Request $request, UserInterface $client): bool
    {
        return $client->getId() != (int)$request->attributes->get('client_id');
    }
}