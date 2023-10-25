<?php

namespace Application\Context\ReferenceBooks\Column\Dto;

interface StringSettingsDto
{
    public function getMinCharCount(): int;
    public function getMaxCharCount(): int;
}
