<?php

/**
 * Create by maxime
 * Date 2/10/2020
 * Time 4:23 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : GetClients.php as GetClients
 */

namespace App\Actions;

use App\Repository\ClientRepository;
use App\Repository\EndUserRepository;
use App\Responder\ResponderJson;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 *@Route(name="get_clients", path="/api/clients", methods={"GET"})
 */
class GetClients
{
    /** @var ClientRepository */
    private $clientsRepository;
/** @var SerializerInterface */
    private $serilizer;
/** @var ResponderJson */
    private $responder;
/**
     * GetClients constructor.
     * @param ClientRepository $clientsRepository
     * @param SerializerInterface $serilizer
     * @param ResponderJson $responder
     */
    public function __construct(
        ClientRepository $clientsRepository,
        SerializerInterface $serilizer,
        ResponderJson $responder
    ) {
        $this->clientsRepository = $clientsRepository;
        $this->serilizer = $serilizer;
        $this->responder = $responder;
    }


    public function __invoke()
    {
        $responder = $this->responder;
        $clients = $this->clientsRepository->findAll();
        $clientsSerialized = $this->serilizer->normalize($clients, 'json', ['groups' => 'list_clients']);
        return $responder($clientsSerialized, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
