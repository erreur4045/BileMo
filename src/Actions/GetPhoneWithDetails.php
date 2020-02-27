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

use App\Actions\Domain\Phones\GetPhonesDetailsResolver;
use App\Responder\ResponderJson;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GetPhones
 * @package App\Actions
 * @Route(name="get_phone", path="/api/phones/{id<\d+>}", methods={"GET"})
 */
class GetPhoneWithDetails
{
    /** @var ResponderJson */
        private $responder;
        /** @var GetPhonesDetailsResolver */
        private $resolver;

    /**
     * GetPhoneWithDetails constructor.
     * @param ResponderJson $responder
     * @param GetPhonesDetailsResolver $resolver
     */
    public function __construct(ResponderJson $responder, GetPhonesDetailsResolver $resolver)
    {
        $this->responder = $responder;
        $this->resolver = $resolver;
    }


    public function __invoke(Request $request)
    {
        $responder = $this->responder;
        $phone = $this->resolver->resolve($request);
        return $responder->response($phone, Response::HTTP_OK, ['Content-Type' => 'application/json'], true);
    }
}
