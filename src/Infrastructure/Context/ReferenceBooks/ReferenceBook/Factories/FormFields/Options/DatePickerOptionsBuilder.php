<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories\FormFields\Options;

use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\Options\DatePickerOptions;

final class DatePickerOptionsBuilder
{
    private DatePickerOptions $datePickerOptions;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): self
    {
        $this->datePickerOptions = new DatePickerOptions();

        return $this;
    }

    public function withFormat(?string $format): self
    {
        $this->datePickerOptions->setFormat($format);

        return $this;
    }

    public function withPlaceholder(?string $placeholder): self
    {
        $this->datePickerOptions->setPlaceholder($placeholder);

        return $this;
    }

    public function build(): DatePickerOptions
    {
        return $this->datePickerOptions;
    }
}
