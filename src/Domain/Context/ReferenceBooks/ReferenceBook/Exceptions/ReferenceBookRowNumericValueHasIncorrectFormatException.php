<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Exceptions;

use Exception;
use Throwable;

class ReferenceBookRowNumericValueHasIncorrectFormatException extends Exception
{
    public function __construct(int $min, int $max, string $columnId, int $code = 404, ?Throwable $previous = null)
    {
        $message = "Числовое значение для колонки $columnId должно быть в диапазоне от $min до $max";
        parent::__construct($message, $code, $previous);
    }
}
