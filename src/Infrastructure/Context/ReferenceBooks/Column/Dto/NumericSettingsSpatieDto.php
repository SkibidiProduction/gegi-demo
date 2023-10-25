<?php

namespace Infrastructure\Context\ReferenceBooks\Column\Dto;

use Application\Context\ReferenceBooks\Column\Dto\NumericSettingsDto;
use Spatie\DataTransferObject\DataTransferObject;

class NumericSettingsSpatieDto extends DataTransferObject implements NumericSettingsDto
{
    public int $min;
    public int $max;

    public function getMin(): int
    {
        return $this->min;
    }

    public function getMax(): int
    {
        return $this->max;
    }
}
