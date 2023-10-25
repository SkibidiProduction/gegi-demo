<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Exceptions;

use Exception;
use Throwable;

class ReferenceBookRowStringValueHasIncorrectFormatException extends Exception
{
    public function __construct(int $min, int $max, string $columnId, int $code = 404, ?Throwable $previous = null)
    {
        $message = "Длина строкового значения для колонки $columnId должна быть в диапазоне от $min до $max символов";
        parent::__construct($message, $code, $previous);
    }
}
