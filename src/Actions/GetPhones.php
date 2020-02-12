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
    /** @var SerializerInterface */
    private $serializer;
    /** @var ResponderJson */
    private $responder;
    /**
     * GetPhones constructor.
     * @param PhoneRepository $phoneRepository
     * @param SerializerInterface $serializer
     * @param ResponderJson $responder
     */
    public function __construct(
        PhoneRepository $phoneRepository,
        SerializerInterface $serializer,
        ResponderJson $responder
    ) {
        $this->phoneRepository = $phoneRepository;
        $this->serializer = $serializer;
        $this->responder = $responder;
    }


    public function __invoke()
    {
        $responder = $this->responder;
        $phones = $this->phoneRepository->findAll();
        $phonesSerilized = $this->serializer->normalize($phones, 'json', ['groups' => 'phone_details_route']);
        return $responder($phonesSerilized, 200, ['Content-Type' => 'application/json']);
    }
}
