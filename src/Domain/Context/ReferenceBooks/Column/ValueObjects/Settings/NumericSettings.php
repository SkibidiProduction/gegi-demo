<?php

namespace Domain\Context\ReferenceBooks\Column\ValueObjects\Settings;

use Domain\Context\ReferenceBooks\Column\ValueObjects\DataType\DataType;
use Throwable;

class NumericSettings implements Settings
{
    protected NumericSettingsValidator $validator;

    /**
     * @throws Throwable
     */
    public function __construct(private readonly int $min, private readonly int $max)
    {
        $this->validator = new NumericSettingsValidator();
        $this->validate();
    }

    public function min(): int
    {
        return $this->min;
    }

    public function max(): int
    {
        return $this->max;
    }

    public function __toString(): string
    {
        return json_encode([
            'min' => $this->min,
            'max' => $this->max,
        ], JSON_THROW_ON_ERROR);
    }

    /**
     * @throws Throwable
     */
    public function validate(): void
    {
        $this->check()->thatNumberRangeRight($this->min, $this->max);
    }

    /**
     * @throws Throwable
     */
    public function checkForComplianceWith(DataType $dataType): void
    {
        $this->check()->thatObjectMustBeComplianceWithDataTypeRule($dataType);
    }

    protected function check(): NumericSettingsValidator
    {
        return $this->validator;
    }

    public function toArray(): array
    {
        return [
            'min' => $this->min,
            'max' => $this->max,
        ];
    }
}
