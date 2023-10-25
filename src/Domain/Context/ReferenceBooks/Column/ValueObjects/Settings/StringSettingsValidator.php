<?php

namespace Domain\Context\ReferenceBooks\Column\ValueObjects\Settings;

use Domain\Context\ReferenceBooks\Column\Enums\DataTypeEnum;
use Domain\Context\ReferenceBooks\Column\ValueObjects\DataType\DataType;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\Exceptions\CharactersNumberInWrongRangeException;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\Exceptions\WrongDataTypeException;
use Throwable;

class StringSettingsValidator
{
    public const MINIMUM_CHARACTERS_COUNT = 0;
    public const MAXIMUM_CHARACTERS_COUNT = 255;

    /**
     * @throws Throwable
     */
    public function thatCharactersNumberRangeRight(int $min, int $max): void
    {
        if (!$this->isCharactersNumberInRightRange($min, $max)) {
            throw new CharactersNumberInWrongRangeException(
                self::MINIMUM_CHARACTERS_COUNT,
                self::MAXIMUM_CHARACTERS_COUNT
            );
        }
    }

    /**
     * @throws Throwable
     */
    public function thatObjectMustBeComplianceWithDataTypeRule(DataType $dataType): void
    {
        if ($this->isNotStringDataType($dataType)) {
            throw new WrongDataTypeException();
        }
    }

    protected function isNotStringDataType(DataType $dataType): bool
    {
        return $dataType->value() !== DataTypeEnum::String->value;
    }

    protected function isCharactersNumberInRightRange(int $min, int $max): bool
    {
        return $min >= self::MINIMUM_CHARACTERS_COUNT && $max <= self::MAXIMUM_CHARACTERS_COUNT && $max >= $min;
    }
}
