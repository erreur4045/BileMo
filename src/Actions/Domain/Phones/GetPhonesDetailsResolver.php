<?php
/**
 * Create by maxime
 * Date 2/21/2020
 * Time 2:18 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : GetPhonesDetailsResolver.php as GetPhonesDetailsResolver
 */

namespace App\Actions\Domain\Phones;


use App\Repository\PhoneRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;

class GetPhonesDetailsResolver
{
    /** @var PhoneRepository */
    private $phoneRepository;
    /** @var SerializerInterface */
    private $serialize;

    /**
     * GetPhonesDetailsResolver constructor.
     * @param PhoneRepository $phoneRepository
     * @param SerializerInterface $serialize
     */
    public function __construct(
        PhoneRepository $phoneRepository,
        SerializerInterface $serialize
    ) {
        $this->phoneRepository = $phoneRepository;
        $this->serialize = $serialize;
    }

    public function resolve(Request $request)
    {
        if (is_int((int)$request->attributes->get('id')) == false OR strlen($request->attributes->get('id')) != strlen((int)$request->attributes->get('id'))){
            throw new BadRequestHttpException('The parameter is not valid, a value of type int is requested.', null, Response::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json']);
        }
        $phone = $this->phoneRepository->find($request->attributes->get('id'));
        if ($phone == null){
            throw new NotFoundHttpException('Phone was not found, check your request', null, Response::HTTP_NOT_FOUND,
                ['Content-Type' => 'application/json']);
        }
        $phoneNormalized = $this->serialize->normalize($phone, 'json', ['groups' => 'phone_details_route']);
        return $phoneNormalized;
    }
}