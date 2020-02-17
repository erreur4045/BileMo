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

use App\Repository\ClientRepository;
use App\Repository\EndUserRepository;
use App\Responder\ResponderJson;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class DeleteEndUser
 * @package App\Actions
 * @Route(name="delete_users", path="/api/users/{id}", methods={"DELETE"})
 */
class DeleteEndUser
{
    /** @var SerializerInterface */
    private $serializer;
    /** @var ResponderJson */
        private $responder;
    /** @var ClientRepository */
        private $clientRepository;
    /** @var EndUserRepository */
        private $endUserRepository;
    /** @var EntityManagerInterface */
        private $em;
    /**
     * DeleteEndUser constructor.
     * @param SerializerInterface $serializer
     * @param ResponderJson $responder
     * @param ClientRepository $clientRepository
     * @param EndUserRepository $endUserRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(
        SerializerInterface $serializer,
        ResponderJson $responder,
        ClientRepository $clientRepository,
        EndUserRepository $endUserRepository,
        EntityManagerInterface $em
    ) {
        $this->serializer = $serializer;
        $this->responder = $responder;
        $this->clientRepository = $clientRepository;
        $this->endUserRepository = $endUserRepository;
        $this->em = $em;
    }

    public function __invoke(Request $request)
    {
        //todo: controle de l'utilisateur if()
        $responder = $this->responder;
        $endUserToDelete = $this->endUserRepository->findOneBy(['id' => $request->attributes->get('id')]);
        $this->em->remove($endUserToDelete);
        $this->em->flush();
        return $responder(null, Response::HTTP_NO_CONTENT, ['Content-Type' => 'application/json']);
    }
}
