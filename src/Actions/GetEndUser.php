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

use App\Repository\ClientRepository;
use App\Repository\EndUserRepository;
use App\Responder\ResponderJson;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class GetEnduserByClient
 * @package App\Actions
 * @Route(name="get_user", path="/api/users/{id}", methods={"GET"})
 */
class GetEndUser
{
    /** @var SerializerInterface */
        private $serializer;
    /** @var EndUserRepository */
        private $enduserRepository;
    /** @var ResponderJson */
        private $responder;

    /**
     * GetEnduserByClient constructor.
     * @param ClientRepository $clientRepository
     * @param SerializerInterface $serializer
     * @param EndUserRepository $enduserRepository
     * @param ResponderJson $responder
     */
    public function __construct(
        SerializerInterface $serializer,
        EndUserRepository $enduserRepository,
        ResponderJson $responder
    ) {
        $this->serializer = $serializer;
        $this->enduserRepository = $enduserRepository;
        $this->responder = $responder;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $responder = $this->responder;
        $endClient = $this->enduserRepository->findOneBy(['id' => $request->attributes->get('id')]);
        $endClientsSerialised = $this->serializer->normalize($endClient, 'json', ['groups' => 'user_details_route']);
        return $responder($endClientsSerialised, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
