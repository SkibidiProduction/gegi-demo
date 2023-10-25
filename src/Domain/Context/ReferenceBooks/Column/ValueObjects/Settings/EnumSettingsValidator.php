<?php

namespace Domain\Context\ReferenceBooks\Column\ValueObjects\Settings;

use Domain\Context\ReferenceBooks\Column\Enums\DataTypeEnum;
use Domain\Context\ReferenceBooks\Column\ValueObjects\DataType\DataType;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\Exceptions\WrongDataTypeException;
use Throwable;

class EnumSettingsValidator
{
    /**
     * @throws Throwable
     */
    public function thatObjectMustBeComplianceWithDataTypeRule(DataType $dataType): void
    {
        if ($this->isNotEnumDataType($dataType)) {
            throw new WrongDataTypeException();
        }
    }

    protected function isNotEnumDataType(DataType $dataType): bool
    {
        return $dataType->value() !== DataTypeEnum::Enum->value;
    }
}
