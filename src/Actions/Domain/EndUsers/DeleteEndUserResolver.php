<?php

/**
 * Create by maxime
 * Date 2/23/2020
 * Time 11:23 AM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : DeleteEndUserResolver.php as DeleteEndUserResolver
 */

namespace App\Actions\Domain\EndUsers;

use App\Entity\EndUser;
use App\Repository\EndUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class DeleteEndUserResolver
 * @package App\Actions\Domain\EndUsers
 */
class DeleteEndUserResolver
{
    /** @var SerializerInterface */
    private $serializer;
    /** @var TokenStorageInterface */
        private $storage;
    /** @var EntityManagerInterface */
        private $manager;
    /** @var ValidatorInterface */
        private $validator;
    /** @var EndUserRepository */
        private $endUserRepo;
    /**
     * DeleteEndUserResolver constructor.
     * @param SerializerInterface $serializer
     * @param TokenStorageInterface $storage
     * @param EntityManagerInterface $manager
     * @param ValidatorInterface $validator
     * @param EndUserRepository $endUserRepo
     */
    public function __construct(
        SerializerInterface $serializer,
        TokenStorageInterface $storage,
        EntityManagerInterface $manager,
        ValidatorInterface $validator,
        EndUserRepository $endUserRepo
    ) {
        $this->serializer = $serializer;
        $this->storage = $storage;
        $this->manager = $manager;
        $this->validator = $validator;
        $this->endUserRepo = $endUserRepo;
    }

    /**
     * @param Request $request
     * @param UserInterface $client
     * @throws Exception
     */
    public function resolve(Request $request, UserInterface $client)
    {
        if ($this->storage->getToken()->getUser() == null or (int)$request->get('client_id') != $client->getId()) {
            throw new AccessDeniedHttpException('You can\'t delete this user', null, Response::HTTP_UNAUTHORIZED);
        } elseif ($this->manager->getRepository(EndUser::class)->find($request->get('id')) == null) {
            throw new Exception('User doesn\'t exist', Response::HTTP_BAD_REQUEST);
        } else {
            $this->manager->remove($this->manager->getRepository(EndUser::class)->find($request->get('id')));
            $this->manager->flush();
        }
    }
}
