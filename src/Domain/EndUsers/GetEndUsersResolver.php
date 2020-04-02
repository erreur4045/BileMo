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

use App\Entity\EndUser;
use App\OwnTools\Back\CheckParams;
use App\OwnTools\Back\MakePagination;
use App\OwnTools\Back\Pagination\PaginationTools;
use App\OwnTools\Back\URI\AttributesTools;
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
    /** @var AttributesTools */
        private $attributesTools;
    /** @var PaginationTools */
        private $paginationTools;

    /**
     * GetEndUsersResolver constructor.
     * @param EndUserRepository $endUserRepository
     * @param SerializerInterface $serializer
     * @param MakePagination $paginator
     * @param CheckParams $checkParams
     * @param AttributesTools $attributesTools
     * @param PaginationTools $paginationTools
     */
    public function __construct(
        EndUserRepository $endUserRepository,
        SerializerInterface $serializer,
        MakePagination $paginator,
        CheckParams $checkParams,
        AttributesTools $attributesTools,
        PaginationTools $paginationTools
    ) {
        $this->endUserRepository = $endUserRepository;
        $this->serializer = $serializer;
        $this->paginator = $paginator;
        $this->checkParams = $checkParams;
        $this->attributesTools = $attributesTools;
        $this->paginationTools = $paginationTools;
    }

    public function resolve(Request $request, UserInterface $client)
    {
        $clientId = (int)$request->attributes->get('client_id');
        if ($this->attributesTools->isClientLegitimate($request, $client)) {
            throw new ForbiddenOverwriteException(
                'You can\'t access these resources.',
                Response::HTTP_UNAUTHORIZED,
                null
            );
        }
        $page = $request->query->get('page');
        $endUsersCount = $this->endUserRepository->countEndUsers($clientId);
        $this->paginationTools->filterUnconsistentPageNumber($page, $endUsersCount);
        $currentPageEndUsers = ($this->paginationTools->isPaginationNeeded($endUsersCount)) ?
            $this->getCurrentPageEndUsersAfterPagination($request, $page, $endUsersCount) :
            $this->getEndUsers();
        return $this->serializer->normalize(
            $currentPageEndUsers,
            'json',
            ['groups' => 'list_users']
        );
    }

    /**
     * @param Request $request
     * @param $page
     * @param $nbEndUsers
     * @return mixed
     */
    private function getCurrentPageEndUsersAfterPagination(
        Request $request,
        $page,
        $nbEndUsers
    ) {
        return $this->paginator->paginate(
            $page,
            $nbEndUsers,
            $this->endUserRepository,
            $request->attributes->getInt('client_id')
        );
    }

    /**
     * @return EndUser[]
     */
    private function getEndUsers(): array
    {
        return $this->endUserRepository->findBy(
            [],
            [],
            MakePagination::LIMIT_PER_PAGE
        );
    }
}
