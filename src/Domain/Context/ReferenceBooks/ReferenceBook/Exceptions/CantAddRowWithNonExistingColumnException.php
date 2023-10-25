<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Exceptions;

use Exception;
use Throwable;

class CantAddRowWithNonExistingColumnException extends Exception
{
    public function __construct(int $code = 404, ?Throwable $previous = null)
    {
        $message = 'В элементе присутствует значение несуществующей колонки';
        parent::__construct($message, $code, $previous);
    }
}
