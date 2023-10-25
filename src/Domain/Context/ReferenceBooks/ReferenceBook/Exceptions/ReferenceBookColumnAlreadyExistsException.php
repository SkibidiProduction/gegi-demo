<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Exceptions;

use Exception;
use Throwable;

class ReferenceBookColumnAlreadyExistsException extends Exception
{
    public function __construct(int $code = 404, ?Throwable $previous = null)
    {
        $message = 'Данная колонка уже присутствует в справочнике';
        parent::__construct($message, $code, $previous);
    }
}
