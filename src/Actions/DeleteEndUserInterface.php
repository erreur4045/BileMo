<?php
/**
 * Create by maxime
 * Date 4/2/2020
 * Time 9:33 AM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : DeleteEndUserInterface.php as ${NAME}
 */

namespace App\Actions;


use App\Domain\EndUsers\DeleteEndUserResolver;
use App\Responder\ResponderJson;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

interface DeleteEndUserInterface
{
    /**
     * DeleteEndUser constructor.
     * @param ResponderJson $responder
     * @param DeleteEndUserResolver $resolver
     */
    public function __construct(ResponderJson $responder, DeleteEndUserResolver $resolver);

    public function __invoke(Request $request, UserInterface $client): JsonResponse;
}