<?php

namespace Domain\Context\ReferenceBooks\Column\ValueObjects\Name\Exceptions;

use Exception;
use Throwable;

class ColumnNameIsTooLongException extends Exception
{
    public function __construct(int $value, int $code = 422, ?Throwable $previous = null)
    {
        $message = "Имя колонки справочника не должно быть длиннее $value символов";
        parent::__construct($message, $code, $previous);
    }
}
