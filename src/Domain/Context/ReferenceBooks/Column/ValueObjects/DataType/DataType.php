<?php

namespace Domain\Context\ReferenceBooks\Column\ValueObjects\DataType;

use Domain\Context\ReferenceBooks\Column\Enums\DataTypeEnum;

class DataType
{
    public function __construct(private readonly DataTypeEnum $dataType)
    {
    }

    public function value(): string
    {
        return $this->dataType->value;
    }

    public function asEnum(): DataTypeEnum
    {
        return $this->dataType;
    }

    public function __toString(): string
    {
        return $this->dataType->value;
    }
}
