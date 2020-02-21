<?php
/**
 * Create by maxime
 * Date 2/16/2020
 * Time 10:30 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : ValidatorExceptionCustom.php as ValidatorExceptionCustom
 */

namespace App\Actions\Domain\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class ValidatorExceptionCustom extends ValidatorException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    static function create($error)
    {
        foreach ($error as $item) {
            /** @var ConstraintViolation $item */
            dump($item);
            $data = [
              'message' => $item->getMessage(),
                'property' => $item->getPropertyPath()
            ];
        }
    }
}