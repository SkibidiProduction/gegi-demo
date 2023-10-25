<?php

namespace Domain\Context\ReferenceBooks\Column\ValueObjects\Settings;

use Domain\Context\ReferenceBooks\Column\ValueObjects\DataType\DataType;

interface Settings
{
    public function checkForComplianceWith(DataType $dataType): void;

    public function toArray(): array;
}
