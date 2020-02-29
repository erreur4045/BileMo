<?php

/**
 * Create by maxime
 * Date 2/21/2020
 * Time 5:43 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : GetEndUsersResolver.php as GetEndUsersResolver
 */

namespace App\Domain\EndUsers;

use App\OwnTools\Back\CheckParams;
use App\OwnTools\Back\MakePagination;
use App\Repository\EndUserRepository;
use Symfony\Component\Config\Definition\Exception\ForbiddenOverwriteException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

class GetEndUsersResolver
{
    /** @var EndUserRepository */
        private $endUserRepository;
    /** @var SerializerInterface */
        private $serializer;
    /** @var MakePagination */
        private $paginator;
    /** @var CheckParams */
        private $checkParams;

    /**
     * GetEndUsersResolver constructor.
     * @param EndUserRepository $endUserRepository
     * @param SerializerInterface $serializer
     * @param MakePagination $paginator
     * @param CheckParams $checkParams
     */
    public function __construct(
        EndUserRepository $endUserRepository,
        SerializerInterface $serializer,
        MakePagination $paginator,
        CheckParams $checkParams
    ) {
        $this->endUserRepository = $endUserRepository;
        $this->serializer = $serializer;
        $this->paginator = $paginator;
        $this->checkParams = $checkParams;
    }


    public function resolve(Request $request, UserInterface $client)
    {
        $clientId = (int)$request->attributes->get('client_id');
        if ((int)$client->getId() != $clientId) {
            throw new ForbiddenOverwriteException(
                'You can\'t access these resources.',
                Response::HTTP_UNAUTHORIZED,
                null
            );
        }
        $page = $request->query->get('page');
        $nbEndUsers = $this->endUserRepository->countEndUsers($clientId);
        $needPaginate = ceil($nbEndUsers / MakePagination::LIMIT_PER_PAGE) > 1 ? true : false;
        $this->checkParams->isValid($page, $nbEndUsers);
        $needPaginate == true ? $phones = $this->paginator->paginate($page, $nbEndUsers, $this->endUserRepository, $request->attributes->getInt('client_id')) : $phones = $this->endUserRepository->findBy([], [], MakePagination::LIMIT_PER_PAGE);
        $usersNormalized =  $this->serializer->normalize($phones, 'json', ['groups' => 'list_users']);
        return $usersNormalized;
    }
}
