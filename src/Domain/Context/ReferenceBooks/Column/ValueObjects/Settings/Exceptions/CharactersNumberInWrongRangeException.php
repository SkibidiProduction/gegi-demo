<?php

namespace Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\Exceptions;

use Exception;
use Throwable;

class CharactersNumberInWrongRangeException extends Exception
{
    public function __construct(int $min, int $max, int $code = 422, ?Throwable $previous = null)
    {
        $message = "Количество символов в строковом парамете должно быть в диапазоне от $min до $max";
        parent::__construct($message, $code, $previous);
    }
}
