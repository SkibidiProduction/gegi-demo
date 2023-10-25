<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Exceptions;

use Exception;
use Throwable;

class ReferenceBookUpdateDraftNotFoundException extends Exception
{
    public function __construct(int $code = 404, ?Throwable $previous = null)
    {
        $message = 'Черновик редактирования справочника не найден';
        parent::__construct($message, $code, $previous);
    }
}
