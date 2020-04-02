<?php
/**
 * Create by maxime
 * Date 4/2/2020
 * Time 12:02 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : PaginationTools.php as PaginationTools
 */

namespace App\OwnTools\Back\Pagination;


use App\OwnTools\Back\MakePagination;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PaginationTools
{
    /**
     * @param $elementsCount
     * @return bool
     */
    public function isPaginationNeeded($elementsCount): bool
    {
        return ceil($elementsCount / MakePagination::LIMIT_PER_PAGE) > 1;
    }

    public function filterUnconsistentPageNumber($page, $nbItems)
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

        if (strlen($page) > strlen((int)$page)) {
            throw new BadRequestHttpException(
                'Param page incorrect',
                null,
                Response::HTTP_BAD_REQUEST,
                ['Content-type' => 'application/json']
            );
        }
    }
}