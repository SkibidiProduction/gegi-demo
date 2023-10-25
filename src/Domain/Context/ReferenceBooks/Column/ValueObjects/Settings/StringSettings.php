<?php

namespace Domain\Context\ReferenceBooks\Column\ValueObjects\Settings;

use Domain\Context\ReferenceBooks\Column\ValueObjects\DataType\DataType;
use Throwable;

class StringSettings implements Settings
{
    protected StringSettingsValidator $validator;

    /**
     * @throws Throwable
     */
    public function __construct(private readonly int $minCharactersNumber, private readonly int $maxCharactersNumber)
    {
        $this->validator = new StringSettingsValidator();
        $this->validate();
    }

    public function minCharactersNumber(): int
    {
        return $this->minCharactersNumber;
    }

    public function maxCharactersNumber(): int
    {
        return $this->maxCharactersNumber;
    }

    public function __toString(): string
    {
        return json_encode([
            'minCharactersNumber' => $this->minCharactersNumber,
            'maxCharactersNumber' => $this->maxCharactersNumber,
        ], JSON_THROW_ON_ERROR);
    }

    /**
     * @throws Throwable
     */
    public function validate(): void
    {
        $this->check()->thatCharactersNumberRangeRight($this->minCharactersNumber, $this->maxCharactersNumber);
    }

    /**
     * @throws Throwable
     */
    public function checkForComplianceWith(DataType $dataType): void
    {
        $this->check()->thatObjectMustBeComplianceWithDataTypeRule($dataType);
    }

    protected function check(): StringSettingsValidator
    {
        return $this->validator;
    }

    public function toArray(): array
    {
        return [
            'minCharactersNumber' => $this->minCharactersNumber,
            'maxCharactersNumber' => $this->maxCharactersNumber,
        ];
    }
}
