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

use App\Actions\Domain\EndUsers\GetEndUsersResolver;
use App\Repository\EndUserRepository;
use App\Responder\ResponderJson;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 *@Route(name="get_users", path="/api/clients/{client_id<\d+>}/users", methods={"GET"})
 */
class GetEndUsers
{
    /** @var EndUserRepository */
    private $usersRepository;
    /** @var ResponderJson */
    private $responder;
    /** @var SerializerInterface */
    private $serializer;
    /** @var GetEndUsersResolver */
    private $resolver;

    /**
     * GetEndUsers constructor.
     * @param EndUserRepository $usersRepository
     * @param ResponderJson $responder
     * @param SerializerInterface $serializer
     * @param GetEndUsersResolver $resolver
     */
    public function __construct(
        EndUserRepository $usersRepository,
        ResponderJson $responder,
        SerializerInterface $serializer,
        GetEndUsersResolver $resolver
    ) {
        $this->usersRepository = $usersRepository;
        $this->responder = $responder;
        $this->serializer = $serializer;
        $this->resolver = $resolver;
    }


    public function __invoke(Request $request, UserInterface $client)
    {
        $responder = $this->responder;
        $usersNormalized = $this->resolver->resolve($request, $client);
        return $responder->response($usersNormalized, Response::HTTP_OK, ['Content-Type' => 'application/json'], true);
    }
}
