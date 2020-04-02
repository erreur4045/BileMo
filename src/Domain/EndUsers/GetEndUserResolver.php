<?php

/**
 * Create by maxime
 * Date 2/17/2020
 * Time 12:33 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : GetEndUsersResolver.php as GetEndUsersResolver
 */

namespace App\Domain\EndUsers;

use App\OwnTools\Back\URI\AttributesTools;
use App\Repository\EndUserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

class GetEndUserResolver
{
    /** @var EndUserRepository */
    private $endUserRepository;
    /** @var SerializerInterface */
    private $serializer;
    /** @var AttributesTools */
    private $attributesTools;

    /**
     * GetEndUserResolver constructor.
     * @param EndUserRepository $endUserRepository
     * @param SerializerInterface $serializer
     * @param AttributesTools $attributesTools
     */
    public function __construct(
        EndUserRepository $endUserRepository,
        SerializerInterface $serializer,
        AttributesTools $attributesTools
    ) {
        $this->endUserRepository = $endUserRepository;
        $this->serializer = $serializer;
        $this->attributesTools = $attributesTools;
    }

    public function resolve(
        Request $request,
        UserInterface $client
    ) {
        $requestId = $request->attributes->get('id');
        $endUser = $this->endUserRepository->find(['id' => $requestId]);
        if (!$endUser) {
            throw new NotFoundHttpException(
                'User was not found, check your request',
                null,
                Response::HTTP_NOT_FOUND,
                ['Content-Type' => 'application/json']
            );
        }
        if (
            $this->isEndUserNotAssociatedToClient($request, $requestId)
            or $this->attributesTools->isClientLegitimate($request, $client)
        ) {
            throw new AccessDeniedHttpException(
                'You don\'t have the permissions for this resource.',
                null,
                Response::HTTP_UNAUTHORIZED
            );
        }
        return $this->serializer->normalize(
            $endUser,
            'json',
            ['groups' => 'user_details_route']
        );
    }

    /**
     * @param Request $request
     * @param $requestId
     * @return bool
     */
    private function isEndUserNotAssociatedToClient(
        Request $request,
        $requestId
    ): bool {
        return $this->endUserRepository->findOneBy(
                [
                    'id' => $requestId,
                    'client' => $request->attributes->get('client_id')
                ]
            ) == false;
    }
}
