<?php
/**
 * Create by maxime
 * Date 2/22/2020
 * Time 12:43 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : InputExceptions.php as InputExceptions
 */

namespace App\Actions\Domain\Exception;


use Exception;
use Throwable;

class InputExceptions extends Exception
{
    /** @var array */
    protected $errors;

    /**
     * InputExceptions constructor.
     *
     * @param array $errors
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(array $errors, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}