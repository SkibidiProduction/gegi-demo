<?php

namespace Infrastructure\Context\ReferenceBooks\Column\Dto;

use Application\Context\ReferenceBooks\Column\Dto\StringSettingsDto;
use Spatie\DataTransferObject\DataTransferObject;

class StringSettingsSpatieDto extends DataTransferObject implements StringSettingsDto
{
    public int $minCharCount = 0;
    public int $maxCharCount;

    public function getMinCharCount(): int
    {
        return $this->minCharCount;
    }

    public function getMaxCharCount(): int
    {
        return $this->maxCharCount;
    }
}
