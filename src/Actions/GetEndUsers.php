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

use App\Repository\EndUserRepository;
use App\Responder\ResponderJson;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 *@Route(name="get_users", path="/api/users", methods={"GET"})
 */
class GetEndUsers
{
    /** @var EndUserRepository */
    private $usersRepository;
    /** @var ResponderJson */
    private $responder;
    /** @var SerializerInterface */
    private $serializer;

    /**
     * GetUsers constructor.
     * @param EndUserRepository $usersRepository
     * @param SerializerInterface $serilizer
     * @param ResponderJson $responder
     */
    public function __construct(
        EndUserRepository $usersRepository,
        SerializerInterface $serilizer,
        ResponderJson $responder
    ) {
        $this->usersRepository = $usersRepository;
        $this->serializer = $serilizer;
        $this->responder = $responder;
    }

    public function __invoke(UserInterface $client)
    {
        $responder = $this->responder;
        $users = $this->usersRepository->findBy(['client' => $client->getId()]);
        $usersNormalized = $this->serializer->normalize($users, 'json', ['groups' => 'list_users']);
        return $responder($usersNormalized, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
