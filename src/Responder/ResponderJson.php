<?php

/**
 * Create by maxime
 * Date 2/11/2020
 * Time 3:02 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : ResponderJson.php as ResponderJson
 */

namespace App\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponderJson
{
    public function __invoke(
        $data,
        $status = Response::HTTP_OK,
        $header = ['Content-Type' => 'application/json'],
        $cachable = null
    ) {
        return new JsonResponse($data, $status, $header);
    }

    public static function response(
        $data,
        $status = Response::HTTP_OK,
        $header = ['Content-Type' => 'application/json'],
        $cachable = null
    )
    {
        return new JsonResponse($data, $status, $header);
    }
}
