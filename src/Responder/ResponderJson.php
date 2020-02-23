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
    public static function response(
        $data,
        $status = Response::HTTP_OK,
        $header = ['Content-Type' => 'application/json'],
        $cachable = null
    ) {
        $response = new JsonResponse($data, $status, $header);
        if ($cachable) {
            $response->setPublic()->setSharedMaxAge(300)->setMaxAge(300);
        }
        return $response;
    }
}
