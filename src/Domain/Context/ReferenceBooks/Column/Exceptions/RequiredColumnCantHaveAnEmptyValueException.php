<?php

namespace Domain\Context\ReferenceBooks\Column\Exceptions;

use Exception;
use Throwable;

class RequiredColumnCantHaveAnEmptyValueException extends Exception
{
    public function __construct(int $code = 422, ?Throwable $previous = null)
    {
        $message = 'Обязательная колонка не может иметь пустое значение';
        parent::__construct($message, $code, $previous);
    }
}
