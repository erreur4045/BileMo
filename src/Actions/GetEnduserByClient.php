<?php

/**
 * Create by maxime
 * Date 2/12/2020
 * Time 1:33 AM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : GetEnduserByClient.php as GetEnduserByClient
 */

namespace App\Actions;

use App\Repository\ClientRepository;
use App\Repository\SupplierRepository;
use App\Responder\ResponderJson;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class GetEnduserByClient
 * @package App\Actions
 * @Route(name="get_endusers", path="/api/clients/{id}", methods={"GET"})
 */
class GetEnduserByClient
{
    /** @var ClientRepository */
    private $clientRepository;
    /** @var SerializerInterface */
        private $serializer;
    /** @var SupplierRepository */
        private $supplierRepository;
    /** @var ResponderJson */
        private $responder;
    /**
     * GetEnduserByClient constructor.
     * @param ClientRepository $clientRepository
     * @param SerializerInterface $serializer
     * @param SupplierRepository $supplierRepository
     * @param ResponderJson $responder
     */
    public function __construct(
        ClientRepository $clientRepository,
        SerializerInterface $serializer,
        SupplierRepository $supplierRepository,
        ResponderJson $responder
    ) {
        $this->clientRepository = $clientRepository;
        $this->serializer = $serializer;
        $this->supplierRepository = $supplierRepository;
        $this->responder = $responder;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $responder = $this->responder;
        $endClient = $this->clientRepository->findOneBy(['id' => $request->attributes->get('id')]);
        $endClientsSerialised = $this->serializer->normalize($endClient, 'json', ['groups' => 'user_details_route']);
        return $responder($endClientsSerialised, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
