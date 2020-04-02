<?php

/**
 * Create by maxime
 * Date 2/10/2020
 * Time 4:23 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : GetEndUsers.php as GetEndUsers
 */

namespace App\Actions;

use App\Domain\EndUsers\GetEndUsersResolver;
use App\Repository\EndUserRepository;
use App\Responder\ResponderJson;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 *@Route(
 *     name="get_users",
 *     path="/api/clients/{client_id<\d+>}/users",
 *     methods={"GET"},
 *     requirements={"client_id"="\d+"}
 *     )
 */
class GetEndUsers
{
    /** @var ResponderJson */
        private $responder;
    /** @var GetEndUsersResolver */
        private $resolver;

    /**
     * GetEndUsers constructor.
     * @param ResponderJson $responder
     * @param GetEndUsersResolver $resolver
     */
    public function __construct(
        ResponderJson $responder,
        GetEndUsersResolver $resolver
    ) {
        $this->responder = $responder;
        $this->resolver = $resolver;
    }

    public function __invoke(
        Request $request,
        UserInterface $client
    )
    {
        $usersNormalized = $this->resolver->resolve($request, $client);
        return $this->responder->response(
            $usersNormalized,
            Response::HTTP_OK,
            ['Content-Type' => 'application/json'],
            true
        );
    }
}
