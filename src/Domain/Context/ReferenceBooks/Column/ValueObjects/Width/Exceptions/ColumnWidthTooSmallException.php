<?php

namespace Domain\Context\ReferenceBooks\Column\ValueObjects\Width\Exceptions;

use Exception;
use Throwable;

class ColumnWidthTooSmallException extends Exception
{
    public function __construct(int $value, int $code = 422, ?Throwable $previous = null)
    {
        $message = "Ширина колонки не должна быть меньше $value пикселей";
        parent::__construct($message, $code, $previous);
    }
}
