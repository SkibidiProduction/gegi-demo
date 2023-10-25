<?php

namespace Application\Context\ReferenceBooks\Column\Dto;

interface NumericSettingsDto
{
    public function getMin(): int;
    public function getMax(): int;
}
