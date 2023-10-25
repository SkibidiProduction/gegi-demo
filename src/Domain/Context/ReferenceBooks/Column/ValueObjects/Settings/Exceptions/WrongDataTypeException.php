<?php

namespace Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\Exceptions;

use Exception;
use Throwable;

class WrongDataTypeException extends Exception
{
    public function __construct(int $code = 422, ?Throwable $previous = null)
    {
        $message = 'Параметры типа колонки можно использовать только для колонок того же типа';
        parent::__construct($message, $code, $previous);
    }
}
