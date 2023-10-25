<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\ReferenceBookType;

use Domain\Context\ReferenceBooks\ReferenceBook\Enums\TypeEnum;

class Type
{
    public function __construct(protected readonly TypeEnum $type)
    {
    }

    public function value(): string
    {
        return $this->type->value;
    }
}
