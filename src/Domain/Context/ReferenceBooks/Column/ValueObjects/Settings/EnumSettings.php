<?php

namespace Domain\Context\ReferenceBooks\Column\ValueObjects\Settings;

use Domain\Context\ReferenceBooks\Column\ValueObjects\DataType\DataType;
use Throwable;

class EnumSettings implements Settings
{
    protected EnumSettingsValidator $validator;

    /**
     * @throws Throwable
     */
    public function __construct(private readonly string $columnId)
    {
        $this->validator = new EnumSettingsValidator();
    }

    public function columnId(): string
    {
        return $this->columnId;
    }

    public function __toString(): string
    {
        return $this->columnId;
    }

    /**
     * @throws Throwable
     */
    public function checkForComplianceWith(DataType $dataType): void
    {
        $this->check()->thatObjectMustBeComplianceWithDataTypeRule($dataType);
    }

    protected function check(): EnumSettingsValidator
    {
        return $this->validator;
    }

    public function toArray(): array
    {
        return [
            'columnId' => $this->columnId,
        ];
    }
}
