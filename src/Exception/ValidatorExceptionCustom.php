<?php

/**
 * Create by maxime
 * Date 2/16/2020
 * Time 10:30 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : ValidatorExceptionCustom.php as ValidatorExceptionCustom
 */

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidatorExceptionCustom
{
    public static function create(ConstraintViolationListInterface $errors)
    {
        $data = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $data['errors'][] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        return $data;
    }
}
