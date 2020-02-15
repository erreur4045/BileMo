<?php

/**
 * Create by maxime
 * Date 2/12/2020
 * Time 11:04 AM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : PostEnduser.php as PostEnduser
 */

namespace App\Actions;

use App\Entity\EndUser;
use App\Entity\Inputs\EndUserInput;
use App\Repository\ClientRepository;
use App\Responder\ResponderJson;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class PostEnduser
 * @package App\Actions
 * @Route(name="post_enduser", path="api/clients/{id}/enduser", methods={"POST"})
 */
class PostEnduser
{
    /** @var SerializerInterface */
    private $serializer;
    /** @var ResponderJson */
        private $responder;
    /** @var ClientRepository */
        private $clientRepository;
    /** @var EntityManagerInterface */
        private $em;
    /**
     * PostEnduser constructor.
     * @param SerializerInterface $serializer
     * @param ResponderJson $responder
     * @param ClientRepository $clientRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(
        SerializerInterface $serializer,
        ResponderJson $responder,
        ClientRepository $clientRepository,
        EntityManagerInterface $em
    ) {
        $this->serializer = $serializer;
        $this->responder = $responder;
        $this->clientRepository = $clientRepository;
        $this->em = $em;
    }

    public function __invoke(Request $request)
    {
        $responder = $this->responder;
        $client = $this->clientRepository->findOneBy(['id' => $request->attributes->get('id')]);
        /** @var EndUserInput $endUserUnserialised */
        $endUserUnserialised = $this->serializer->deserialize($request->getContent(), EndUser::class, 'json');
        $endUserUnserialised->setClient($client);
        $this->em->persist($endUserUnserialised);
        $this->em->flush();
        return $responder(null, Response::HTTP_CREATED, ['Content-Type' => 'application/json']);
    }
}
