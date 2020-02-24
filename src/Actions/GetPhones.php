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

use App\Actions\Domain\Phones\GetPhonesResolver;
use App\Repository\PhoneRepository;
use App\Responder\ResponderJson;
use Symfony\Component\HttpFoundation\Request;
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
    /** @var ResponderJson */
    private $responder;
    /** @var GetPhonesResolver */
    private $resolver;

    /**
     * GetPhones constructor.
     * @param ResponderJson $responder
     * @param GetPhonesResolver $resolver
     */
    public function __construct(ResponderJson $responder, GetPhonesResolver $resolver)
    {
        $this->responder = $responder;
        $this->resolver = $resolver;
    }

    public function __invoke(Request $request)
    {
        $responder = $this->responder;
        $data =  $this->resolver->resolve($request);
        return $responder->response($data, Response::HTTP_OK, ['Content-Type' => 'application/json'], false);
    }
}
