<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Code\Exceptions;

use Exception;
use Throwable;

class ReferenceBookCodeIsTooLongException extends Exception
{
    public function __construct(int $code = 422, ?Throwable $previous = null)
    {
        $message = 'Код справочника не должен быть длиннее 255 символов';
        parent::__construct($message, $code, $previous);
    }
}
