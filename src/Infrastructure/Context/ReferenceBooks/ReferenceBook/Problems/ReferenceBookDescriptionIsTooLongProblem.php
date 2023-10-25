<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Problems;

use Infrastructure\Shared\Problems\Problem;

class ReferenceBookDescriptionIsTooLongProblem implements Problem
{
    public function __construct(private readonly string $message)
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
