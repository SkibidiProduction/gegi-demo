<?php

namespace Domain\Context\ReferenceBooks\Row;

use Domain\Context\ReferenceBooks\Row\ValueObjects\Value;
use Domain\Shared\ValueObjects\Id\Id;
use Throwable;

final class Row
{
    private Id $id;
    private Id $referenceBookId;

    /** @var array<Value>  */
    private array $values = [];

    /**
     * @throws Throwable
     */
    public function __construct()
    {
        $this->id = Id::new();
    }

    //ACCESSORS

    public function id(): Id
    {
        return $this->id;
    }

    public function values(): array
    {
        return $this->values;
    }

    //MUTATORS

    public function setReferenceBookId(Id $referenceBookId): Row
    {
        $this->referenceBookId = $referenceBookId;
        return $this;
    }

    public function addValue(Value $value): Row
    {
        $this->values[] = $value;
        return $this;
    }

    public function removeValue(Value $value): Row
    {
        foreach ($this->values as $key => $rowValue) {
            if ($rowValue->columnId()->value() === $value->columnId()->value()) {
                unset($this->values[$key]);
                $this->values = array_values($this->values);
            }
        }

        return $this;
    }
}
