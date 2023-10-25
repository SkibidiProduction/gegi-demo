<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Exceptions;

use Exception;
use Throwable;

class ReferenceBookRowAlreadyExistsException extends Exception
{
    public function __construct(int $code = 404, ?Throwable $previous = null)
    {
        $message = 'Данный элемент уже присутствует в справочнике';
        parent::__construct($message, $code, $previous);
    }
}
