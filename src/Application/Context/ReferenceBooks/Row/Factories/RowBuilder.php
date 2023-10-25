<?php

namespace Application\Context\ReferenceBooks\Row\Factories;

use Domain\Context\ReferenceBooks\Row\Row;
use Domain\Context\ReferenceBooks\Row\ValueObjects\Value;
use Domain\Shared\ValueObjects\Id\Id;
use ReflectionException;

class RowBuilder
{
    protected Id $id;
    protected Id $referenceBookId;
    /** @var array<Value>  */
    protected array $values;

    public function withId(Id $id): RowBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function withReferenceBookId(Id $referenceBookId): RowBuilder
    {
        $this->referenceBookId = $referenceBookId;
        return $this;
    }

    public function withValues(array $values): RowBuilder
    {
        $this->values = $values;
        return $this;
    }

    /**
     * @throws ReflectionException
     */
    public function restore(): Row
    {
        $reflection = new \ReflectionClass(Row::class);
        $row = $reflection->newInstanceWithoutConstructor();
        $reflection->getProperty('id')->setValue($row, $this->id);
        $reflection->getProperty('referenceBookId')->setValue($row, $this->referenceBookId);
        $reflection->getProperty('values')->setValue($row, $this->values);

        return $row;
    }
}
