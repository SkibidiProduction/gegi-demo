<?php

namespace Infrastructure\Context\ReferenceBooks\Column\Dto;

use Application\Context\ReferenceBooks\Column\Dto\ColumnSettingsDto;
use Application\Context\ReferenceBooks\Column\Dto\EnumSettingsDto;
use Application\Context\ReferenceBooks\Column\Dto\NumericSettingsDto;
use Application\Context\ReferenceBooks\Column\Dto\StringSettingsDto;
use Spatie\DataTransferObject\DataTransferObject;

class ColumnSettingsSpatieDto extends DataTransferObject implements ColumnSettingsDto
{
    public ?StringSettingsSpatieDto $stringSettings;
    public ?NumericSettingsSpatieDto $numericSettings;
    public ?EnumSettingsSpatieDto $enumSettings;

    public function getStringSettings(): ?StringSettingsDto
    {
        return $this->stringSettings;
    }

    public function getNumericSettings(): ?NumericSettingsDto
    {
        return $this->numericSettings;
    }

    public function getEnumSettings(): ?EnumSettingsDto
    {
        return $this->enumSettings;
    }
}
