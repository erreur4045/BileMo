<?php

/**
 * Create by maxime
 * Date 2/17/2020
 * Time 12:33 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : GetEndUsersResolver.php as GetEndUsersResolver
 */

namespace App\Actions\Domain\EndUsers;

use App\Repository\EndUserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

class GetEndUserResolver
{
    /** @var EndUserRepository */
    private $endUserRepository;
    /** @var SerializerInterface */
    private $serializer;
    /**
     * GetEndUserResolver constructor.
     * @param EndUserRepository $enduserRepository
     * @param SerializerInterface $serializer
     */
    public function __construct(EndUserRepository $enduserRepository, SerializerInterface $serializer)
    {
        $this->endUserRepository = $enduserRepository;
        $this->serializer = $serializer;
    }

    public function resolve(Request $request, UserInterface $client)
    {
        if (
            is_int((int)$request->attributes->get('id')) == false
            or is_int((int)$request->attributes->get('client_id')) == false
            or strlen($request->attributes->get('client_id')) != strlen((int)$request->attributes->get('client_id'))
            or strlen($request->attributes->get('id')) != strlen((int)$request->attributes->get('id'))
        ) {
            throw new BadRequestHttpException(
                'The parameter is not valid, a value of type int is requested.',
                null,
                Response::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json']
            );
        }
        $endUser = $this->endUserRepository->find(['id' => $request->attributes->get('id')]);
        if ($endUser == null) {
            throw new NotFoundHttpException(
                'User was not found, check your request',
                null,
                Response::HTTP_NOT_FOUND,
                ['Content-Type' => 'application/json']
            );
        }
        if (
            $this->endUserRepository->findOneBy(
                [
                    'id' => $request->attributes->get('id'),
                    'client' => $request->attributes->get('client_id')
                ]
            ) == false
            or $client->getId() != (int)$request->attributes->get('client_id')
        ) {
            throw new AccessDeniedHttpException(
                'You don\'t have the permissions for this resource.',
                null,
                Response::HTTP_UNAUTHORIZED
            );
        }
        $endUserSerialised = $this->serializer->normalize($endUser, 'json', ['groups' => 'user_details_route']);
        return $endUserSerialised;
    }
}
