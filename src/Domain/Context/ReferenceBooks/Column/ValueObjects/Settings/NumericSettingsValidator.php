<?php

namespace Domain\Context\ReferenceBooks\Column\ValueObjects\Settings;

use Domain\Context\ReferenceBooks\Column\Enums\DataTypeEnum;
use Domain\Context\ReferenceBooks\Column\ValueObjects\DataType\DataType;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\Exceptions\MaximumValueLessThanMinimumValueException;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\Exceptions\WrongDataTypeException;
use Throwable;

class NumericSettingsValidator
{
    /**
     * @throws Throwable
     */
    public function thatNumberRangeRight(int $min, int $max): void
    {
        if ($this->maxIsLessThanMin($min, $max)) {
            throw new MaximumValueLessThanMinimumValueException();
        }
    }

    /**
     * @throws Throwable
     */
    public function thatObjectMustBeComplianceWithDataTypeRule(DataType $dataType): void
    {
        if ($this->isNotNumericDataType($dataType)) {
            throw new WrongDataTypeException();
        }
    }

    protected function isNotNumericDataType(DataType $dataType): bool
    {
        return $dataType->value() !== DataTypeEnum::Numeric->value;
    }

    protected function maxIsLessThanMin(int $min, int $max): bool
    {
        return $min > $max;
    }
}
