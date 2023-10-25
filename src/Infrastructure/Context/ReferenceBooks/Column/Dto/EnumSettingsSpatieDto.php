<?php

namespace Infrastructure\Context\ReferenceBooks\Column\Dto;

use Application\Context\ReferenceBooks\Column\Dto\EnumSettingsDto;
use Spatie\DataTransferObject\DataTransferObject;

class EnumSettingsSpatieDto extends DataTransferObject implements EnumSettingsDto
{
    public string $referenceBookColumnId;

    public function getReferenceBookColumnId(): string
    {
        return $this->referenceBookColumnId;
    }
}
