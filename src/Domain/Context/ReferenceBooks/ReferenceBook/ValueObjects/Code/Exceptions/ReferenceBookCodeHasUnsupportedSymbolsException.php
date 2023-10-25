<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Code\Exceptions;

use Exception;
use Throwable;

class ReferenceBookCodeHasUnsupportedSymbolsException extends Exception
{
    public function __construct(int $code = 422, ?Throwable $previous = null)
    {
        $message = 'Код справочника может состоять только из латинских символов в нижнем регистре, цифр и нижнего подчеркивания';
        parent::__construct($message, $code, $previous);
    }
}
