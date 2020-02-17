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

use App\Actions\Domain\EndUsers\AddEndUserResolver;
use App\Entity\Client;
use App\Entity\EndUser;
use App\Inputs\EndUserInputs;
use App\Repository\ClientRepository;
use App\Responder\ResponderJson;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class PostEnduser
 * @package App\Actions
 * @Route(name="post_user", path="api/users", methods={"POST"})
 */
class PostEnduser
{
    /** @var SerializerInterface */
        private $serializer;
    /** @var ResponderJson */
        private $responder;
    /** @var TokenStorageInterface */
        private $client;
    /** @var AddEndUserResolver */
        private $resolver;

    /**
     * PostEnduser constructor.
     * @param SerializerInterface $serializer
     * @param ResponderJson $responder
     * @param TokenStorageInterface $client
     * @param AddEndUserResolver $resolver
     */
    public function __construct(
        SerializerInterface $serializer,
        ResponderJson $responder,
        TokenStorageInterface $client,
        AddEndUserResolver $resolver
    ) {
        $this->serializer = $serializer;
        $this->responder = $responder;
        $this->client = $client;
        $this->resolver = $resolver;
    }


    public function __invoke(Request $request)
    {
        $responder = $this->responder;
        $inputdata = $this->resolver->resolve($request);
        return $responder($inputdata, Response::HTTP_CREATED, ['Content-Type' => 'application/json']);
    }
}
