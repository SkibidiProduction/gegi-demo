<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Exceptions;

use Exception;
use Throwable;

class ReferenceBookDescriptionIsTooShortException extends Exception
{
    public function __construct(int $value, int $code = 422, ?Throwable $previous = null)
    {
        $message = "Имя справочника не должно быть короче $value символов";
        parent::__construct($message, $code, $previous);
    }
}
