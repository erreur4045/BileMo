<?php

/**
 * Create by maxime
 * Date 2/16/2020
 * Time 9:22 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : AddEndUserResolver.php as AddEndUserResolver
 */

namespace App\Actions\Domain\EndUsers;

use App\Actions\Domain\Exception\InputExceptions;
use App\Actions\Domain\Exception\ValidatorExceptionCustom;
use App\Actions\Domain\ListenerException\ListenerException;
use App\Entity\EndUser;
use App\Inputs\EndUserInputs;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddEndUserResolver
{

    /** @var SerializerInterface */
        private $serializer;
    /** @var TokenStorageInterface */
        private $storage;
    /** @var EntityManagerInterface */
        private $manager;
    /** @var UrlGeneratorInterface */
        private $url;
    /** @var ValidatorInterface */
        private $validator;
    /**
     * AddEndUserResolver constructor.
     * @param SerializerInterface $serializer
     * @param TokenStorageInterface $storage
     * @param EntityManagerInterface $manager
     * @param UrlGeneratorInterface $url
     * @param ValidatorInterface $validator
     */
    public function __construct(
        SerializerInterface $serializer,
        TokenStorageInterface $storage,
        EntityManagerInterface $manager,
        UrlGeneratorInterface $url,
        ValidatorInterface $validator
    ) {
        $this->serializer = $serializer;
        $this->storage = $storage;
        $this->manager = $manager;
        $this->url = $url;
        $this->validator = $validator;
    }


    public function resolve(Request $request)
    {
        if ($this->storage->getToken()->getUser() == null) {
            throw new AccessDeniedHttpException('You can\'t add an user');
        }
        /** @var EndUserInputs $input */
        $input = $this->serializer->deserialize($request->getContent(), EndUserInputs::class, 'json');
        $this->emailExist($input->getEmail());
        $this->validateInput($input);
        return $this->hydrate($input);
    }

    public function hydrate(EndUserInputs $input)
    {
        $endUser = new EndUser();
        $endUser->setClient($this->storage->getToken()->getUser());
        $endUser->setEmail($input->getEmail());
        $endUser->setLastname($input->getLastname());
        $endUser->setFistname($input->getFistname());
        $this->manager->persist($endUser);
        $this->manager->flush();
        return ["url" => $this->url->generate('get_user', ['id' => $endUser->getId(), 'client_id' => $this->storage->getToken()->getUser()->getId()])];
    }

    public function validateInput(EndUserInputs $inputs)
    {
        $error = $this->validator->validate($inputs);
        if ($error->count() > 0) {
            throw new InputExceptions(ValidatorExceptionCustom::create($error));
        }
    }

    public function emailExist($email)
    {
        if ($this->manager->getRepository(EndUser::class)->findOneBy(['email' => $email]))
            throw new Exception('This email already exists for another user, please change it.', Response::HTTP_BAD_REQUEST, null);
    }
}
