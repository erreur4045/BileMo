<?php

/**
 * Create by maxime
 * Date 2/21/2020
 * Time 5:43 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : GetEndUsersResolver.php as GetEndUsersResolver
 */

namespace App\Actions\Domain\EndUsers;

use App\Repository\EndUserRepository;
use Symfony\Component\Config\Definition\Exception\ForbiddenOverwriteException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

class GetEndUsersResolver
{
    public const LIMIT_PER_PAGE = 10;
    /** @var EndUserRepository */
        private $endUserRepository;
    /** @var SerializerInterface */
        private $serializer;
    /**
     * GetEndUsersResolver constructor.
     * @param EndUserRepository $endUserRepository
     * @param SerializerInterface $serializer
     */
    public function __construct(EndUserRepository $endUserRepository, SerializerInterface $serializer)
    {
        $this->endUserRepository = $endUserRepository;
        $this->serializer = $serializer;
    }

    public function resolve(Request $request, UserInterface $client)
    {
        $connectedClient = (int)$client->getId();
        $clientId = (int)$request->get('client_id');
        if ($connectedClient != $clientId) {
            throw new ForbiddenOverwriteException(
                'You can\'t access these resources.',
                Response::HTTP_UNAUTHORIZED,
                null
            );
        }
        $page = $request->query->get('page');
        $nbEndUsers = $this->endUserRepository->countEndUsers($clientId);
        $nbMaxPage = ceil($nbEndUsers / GetEndUsersResolver::LIMIT_PER_PAGE);
        if ($nbMaxPage > 1 and $page == null) {
            $page = 1;
        }
        if ($page > $nbMaxPage) {
            throw new BadRequestHttpException(
                sprintf(
                    'The requested page does not exist, last page is /api/clients/%s/users?page=%s',
                    $connectedClient,
                    $nbMaxPage
                ),
                null,
                Response::HTTP_BAD_REQUEST,
                ['Content-type' => 'application/json']
            );
        }
        $page == null ? $nextPage = 2 : $nextPage = $page + 1;
        /**
         * Generate the layout for all pages except first
         */
        if ($nbMaxPage > 1 and $page > 1) {
            $endUsers['pagination'] = [
                'first' => sprintf(
                    '/api/clients/%s/users?page=1',
                    $connectedClient
                ),
                'current' => sprintf(
                    '/api/clients/%s/users?page=',
                    $connectedClient
                ) . $page,
                'last' => sprintf(
                    '/api/clients/%s/users?page=',
                    $connectedClient
                ) . $nbMaxPage
            ];
            if ($page < $nbMaxPage) {
                $endUsers['pagination']['next_page'] = sprintf(
                    '/api/clients/%s/users?page=',
                    $connectedClient
                ) . $nextPage;
            }
            $endUsers['users'] = $this->endUserRepository->findBy(
                ['client' => $clientId],
                [],
                GetEndUsersResolver::LIMIT_PER_PAGE,
                $page * GetEndUsersResolver::LIMIT_PER_PAGE - GetEndUsersResolver::LIMIT_PER_PAGE
            );
        } elseif ($nbMaxPage > 1 and $page == 1) {
            /** Generate the layout for the first page if pagination is necessary */
            $endUsers['pagination'] = [
                'current' => sprintf('/api/clients/%s/users?page=', $connectedClient) . $page,
                'next' => sprintf('/api/clients/%s/users?page=', $connectedClient) . $nextPage,
                'last' => sprintf('/api/clients/%s/users?page=', $connectedClient) . $nbMaxPage,
            ];
            $endUsers['users'] = $this->endUserRepository->findBy(
                ['client' => $clientId],
                [],
                GetEndUsersResolver::LIMIT_PER_PAGE
            );
        } else {
            $endUsers = $this->endUserRepository->findBy([], [], GetEndUsersResolver::LIMIT_PER_PAGE);
        }

        $endUsersNormalized =  $this->serializer->normalize($endUsers, 'json', ['groups' => 'list_users']);
        return $endUsersNormalized;
    }
}
