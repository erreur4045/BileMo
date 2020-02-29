<?php

/**
 * Create by maxime
 * Date 2/28/2020
 * Time 6:31 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : CheckParams.php as CheckParams
 */

namespace App\OwnTools\Back;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CheckParams
{
    public function isValid($page, $nbItems)
    {
        $nbMaxPage = ceil($nbItems / MakePagination::LIMIT_PER_PAGE);
        if ($page > $nbMaxPage) {
            throw new BadRequestHttpException(
                sprintf(
                    'The requested page does not exist, last page is api/phones?page=%s',
                    $nbMaxPage
                ),
                null,
                Response::HTTP_BAD_REQUEST,
                ['Content-type' => 'application/json']
            );
        }

        if (strlen($page) > strlen((int)$page) || $page > ceil($nbItems / MakePagination::LIMIT_PER_PAGE)) {
            throw new BadRequestHttpException(
                'Param page incorrect',
                null,
                Response::HTTP_BAD_REQUEST,
                ['Content-type' => 'application/json']
            );
        }
        return true;
    }
}
