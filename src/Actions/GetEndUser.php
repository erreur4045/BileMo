<?php

/**
 * Create by maxime
 * Date 2/12/2020
 * Time 1:33 AM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : GetEndUser.php as GetEndUser
 */

namespace App\Actions;

use App\Actions\Domain\EndUsers\GetEndUserResolver;
use App\Repository\ClientRepository;
use App\Repository\EndUserRepository;
use App\Responder\ResponderJson;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class GetEnduserByClient
 * @package App\Actions
 * @Route(name="get_user", path="/api/clients/{client_id<\d+>}/users/{id<\d+>}", methods={"GET"})
 */
class GetEndUser
{
    /** @var ResponderJson */
        private $responder;
        /** @var GetEndUserResolver */
        private $resolver;

    /**
     * GetEndUser constructor.
     * @param ResponderJson $responder
     * @param GetEndUserResolver $resolver
     */
    public function __construct(
        ResponderJson $responder,
        GetEndUserResolver $resolver
    ) {
        $this->responder = $responder;
        $this->resolver = $resolver;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request, UserInterface $client)
    {
        $responder = $this->responder;
        $endUser = $this->resolver->resolve($request, $client);
        return $responder->response($endUser, Response::HTTP_OK, ['Content-Type' => 'application/json'], true);
    }
}
