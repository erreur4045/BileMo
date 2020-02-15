<?php

/**
 * Create by maxime
 * Date 2/11/2020
 * Time 2:15 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : GetPhones.php as GetPhones
 */

namespace App\Actions;

use App\Repository\PhoneRepository;
use App\Responder\ResponderJson;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class GetPhones
 * @package App\Actions
 * @Route(name="get_phones", path="/api/phones", methods={"GET"})
 */
class GetPhones
{
    /** @var PhoneRepository */
    private $phoneRepository;
    /** @var ResponderJson */
    private $responder;
    /** @var SerializerInterface */
    private $serializer;

    /**
     * GetPhones constructor.
     * @param PhoneRepository $phoneRepository
     * @param ResponderJson $responder
     * @param SerializerInterface $serializer
     */
    public function __construct(
        PhoneRepository $phoneRepository,
        ResponderJson $responder,
        SerializerInterface $serializer
    ) {
        $this->phoneRepository = $phoneRepository;
        $this->responder = $responder;
        $this->serializer = $serializer;
    }

    public function __invoke()
    {
        $responder = $this->responder;
        $phones = $this->phoneRepository->findAll();
        $data =  $this->serializer->normalize($phones, 'json', ['groups' => 'phone_list']);
        return $responder($data, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
