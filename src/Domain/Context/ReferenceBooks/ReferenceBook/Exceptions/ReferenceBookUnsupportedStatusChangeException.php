<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Exceptions;

use Exception;
use Throwable;

class ReferenceBookUnsupportedStatusChangeException extends Exception
{
    public function __construct(int $code = 404, ?Throwable $previous = null)
    {
        $message = 'Неподдерживаемая смена статуса Справочника';
        parent::__construct($message, $code, $previous);
    }
}
