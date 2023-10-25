<?php

namespace Domain\Context\ReferenceBooks\Row\ValueObjects;

use Domain\Shared\ValueObjects\Id\Id;

class Value
{
    private Id $rowId;

    public function __construct(
        private readonly mixed $value,
        private readonly Id $columnId
    ) {
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function columnId(): Id
    {
        return $this->columnId;
    }

    public function setRowId(Id $rowId): Value
    {
        $this->rowId = $rowId;
        return $this;
    }

    public function rowId(): Id
    {
        return $this->rowId;
    }
}
