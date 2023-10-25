<?php

namespace Infrastructure\Context\ReferenceBooks\Column\Problems;

use Infrastructure\Shared\Problems\Problem;

class ReferenceBookColumnIsRequiredMustBeBooleanProblem implements Problem
{
    public function __construct(private readonly string $message)
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
