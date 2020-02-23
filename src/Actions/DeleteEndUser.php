<?php

/**
 * Create by maxime
 * Date 2/12/2020
 * Time 12:56 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : DeleteEndUser.php as DeleteEndUser
 */

namespace App\Actions;

use App\Actions\Domain\EndUsers\DeleteEndUserResolver;
use App\Responder\ResponderJson;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class DeleteEndUser
 * @package App\Actions
 * @Route(name="delete_users", path="/api/clients/{client_id}/users/{id}", methods={"DELETE"})
 */
class DeleteEndUser
{
    /** @var ResponderJson */
    private $responder;
    /** @var DeleteEndUserResolver */
    private $resolver;

    /**
     * DeleteEndUser constructor.
     * @param ResponderJson $responder
     * @param DeleteEndUserResolver $resolver
     */
    public function __construct(
        ResponderJson $responder,
        DeleteEndUserResolver $resolver
    ) {
        $this->responder = $responder;
        $this->resolver = $resolver;
    }

    public function __invoke(Request $request, UserInterface $client)
    {
        $responder = $this->responder;
        $this->resolver->resolve($request, $client);
        return $responder->response(null, Response::HTTP_NO_CONTENT, ['Content-Type' => 'application/json']);
    }
}
