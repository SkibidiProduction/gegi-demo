<?php

namespace Domain\Context\ReferenceBooks\Column\Exceptions;

use Exception;
use Throwable;

class ReferenceBookIdAlreadySetException extends Exception
{
    public function __construct(int $code = 422, ?Throwable $previous = null)
    {
        $message = 'Данная колонка уже принадлежит справочнику. Изменить справочник нельзя';
        parent::__construct($message, $code, $previous);
    }
}
