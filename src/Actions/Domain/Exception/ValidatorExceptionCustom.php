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

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

class ValidatorExceptionCustom extends ValidatorException
{
    public function __invoke($ex)
   {
       dd("kikou");
    dd($this->exceptions);
   }
}