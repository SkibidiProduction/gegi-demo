<?php

namespace Infrastructure\Context\ReferenceBooks\Row\Problems;

use Infrastructure\Shared\Problems\Problem;

class ReferenceBookRowIdsIsRequiredProblem implements Problem
{
    public function __construct(private readonly string $message)
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
