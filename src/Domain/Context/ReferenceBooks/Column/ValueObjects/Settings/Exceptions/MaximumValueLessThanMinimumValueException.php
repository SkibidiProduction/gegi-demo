<?php

namespace Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\Exceptions;

use Exception;
use Throwable;

class MaximumValueLessThanMinimumValueException extends Exception
{
    public function __construct(int $code = 422, ?Throwable $previous = null)
    {
        $message = 'Максимальное значение не может быть меньше минимального';
        parent::__construct($message, $code, $previous);
    }
}
