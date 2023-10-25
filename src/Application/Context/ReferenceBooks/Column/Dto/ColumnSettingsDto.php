<?php

namespace Application\Context\ReferenceBooks\Column\Dto;

interface ColumnSettingsDto
{
    public function getStringSettings(): ?StringSettingsDto;
    public function getNumericSettings(): ?NumericSettingsDto;
    public function getEnumSettings(): ?EnumSettingsDto;
}
