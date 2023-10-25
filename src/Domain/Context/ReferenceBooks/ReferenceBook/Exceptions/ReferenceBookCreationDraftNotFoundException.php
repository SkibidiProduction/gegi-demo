<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Exceptions;

use Exception;
use Throwable;

class ReferenceBookCreationDraftNotFoundException extends Exception
{
    public function __construct(int $code = 404, ?Throwable $previous = null)
    {
        $message = 'Черновик создания справочника не найден';
        parent::__construct($message, $code, $previous);
    }
}
