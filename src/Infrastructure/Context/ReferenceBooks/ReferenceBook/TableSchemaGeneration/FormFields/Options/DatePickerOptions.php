<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\Options;

final class DatePickerOptions
{
    private ?string $format = null;

    private ?string $placeholder = null;

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function setFormat(?string $format): void
    {
        $this->format = $format;
    }

    public function setPlaceholder(?string $placeholder): void
    {
        $this->placeholder = $placeholder;
    }
}
