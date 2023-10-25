<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Code\Exceptions;

use Exception;
use Throwable;

class ReferenceBookCodeIsTooShortException extends Exception
{
    public function __construct(int $code = 422, ?Throwable $previous = null)
    {
        $message = 'Код справочника не должен быть короче 3 символов';
        parent::__construct($message, $code, $previous);
    }
}
