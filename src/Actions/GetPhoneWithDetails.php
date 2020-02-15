<?php

/**
 * Create by maxime
 * Date 2/11/2020
 * Time 2:41 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : GetPhoneWithDetails.php as GetPhoneWithDetails
 */

namespace App\Actions;

use App\Repository\PhoneRepository;
use App\Repository\SupplierRepository;
use App\Responder\ResponderJson;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class GetPhones
 * @package App\Actions
 * @Route(name="get_phone", path="/api/phones/{id}", methods={"GET"})
 */
class GetPhoneWithDetails
{
    /** @var PhoneRepository */
    private $phoneRepository;
    /** @var SerializerInterface */
        private $serializer;
    /** @var SupplierRepository */
        private $supplierRepository;
    /** @var ResponderJson */
        private $responder;
    /**
     * GetPhoneWithDetails constructor.
     * @param PhoneRepository $phoneRepository
     * @param SerializerInterface $serializer
     * @param SupplierRepository $supplierRepository
     * @param ResponderJson $responder
     */
    public function __construct(
        PhoneRepository $phoneRepository,
        SerializerInterface $serializer,
        SupplierRepository $supplierRepository,
        ResponderJson $responder
    ) {
        $this->phoneRepository = $phoneRepository;
        $this->serializer = $serializer;
        $this->supplierRepository = $supplierRepository;
        $this->responder = $responder;
    }

    public function __invoke(Request $request)
    {
        $responder = $this->responder;
        $phone = $this->phoneRepository->findOneBy(['id' => $request->attributes->get('id')]);
        $phonesNormalized = $this->serializer->normalize($phone, 'json', ['groups' => 'phone_details_route']);
        return $responder($phonesNormalized);
    }
}
