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


use App\Actions\Domain\Exception\ValidatorExceptionCustom;
use App\Entity\EndUser;
use App\Inputs\EndUserInputs;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
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
    /** @var  AuthorizationCheckerInterface*/
    private $autorization;
    /** @var UrlGeneratorInterface */
    private $url;
    /** @var ValidatorInterface */
    private $validator;

    /**
     * AddEndUserResolver constructor.
     * @param SerializerInterface $serializer
     * @param TokenStorageInterface $storage
     * @param EntityManagerInterface $manager
     * @param AuthorizationCheckerInterface $autorization
     * @param UrlGeneratorInterface $url
     * @param ValidatorInterface $validator
     */
    public function __construct(
        SerializerInterface $serializer,
        TokenStorageInterface $storage,
        EntityManagerInterface $manager,
        AuthorizationCheckerInterface $autorization,
        UrlGeneratorInterface $url,
        ValidatorInterface $validator
    ) {
        $this->serializer = $serializer;
        $this->storage = $storage;
        $this->manager = $manager;
        $this->autorization = $autorization;
        $this->url = $url;
        $this->validator = $validator;
    }


    public function resolve(Request $request)
    {
        if ($this->storage->getToken()->getUser() == null)
            throw new AccessDeniedHttpException('You can\'t add a user');

        /** @var EndUserInputs $input */
        $input = $this->serializer->deserialize($request->getContent(),EndUserInputs::class,'json');
        $this->validateInput($input);
        $input->setClient($this->storage->getToken()->getUser());
        return $this->hydrate($input);

    }

    public function hydrate(EndUserInputs $input)
    {
        $endUser = new EndUser();
        $endUser->setClient($input->getClient());
        $endUser->setEmail($input->getEmail());
        try{
            $endUser->setLastname($input->getLastname());
        }catch (\Exception $exception){
            return [$exception];
        }
        $endUser->setFistname($input->getFistname());

        $this->manager->persist($endUser);
        $this->manager->flush();

        return ["url" => $this->url->generate('get_user',['id' => $endUser->getId()])];
    }

    public function validateInput(EndUserInputs $inputs)
    {
        $error = $this->validator->validate($inputs);
        if ($error->count()>0){
            dd($error->get(0)->getMessageTemplate());
            throw new ValidatorExceptionCustom($error);
        }
    }
}