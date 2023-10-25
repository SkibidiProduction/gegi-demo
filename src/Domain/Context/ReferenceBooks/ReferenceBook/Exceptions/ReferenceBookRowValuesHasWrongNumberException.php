<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Exceptions;

use Exception;
use Throwable;

class ReferenceBookRowValuesHasWrongNumberException extends Exception
{
    public function __construct(int $code = 404, ?Throwable $previous = null)
    {
        $message = 'Неверное количество значений элемента';
        parent::__construct($message, $code, $previous);
    }
}
