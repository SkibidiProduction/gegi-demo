<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields;

use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\Options\DatePickerOptions;

final class FormFieldDatePicker extends FormFieldBase implements FormField
{
    private ?DatePickerOptions $options = null;

    public function getOptions(): ?DatePickerOptions
    {
        return $this->options;
    }

    public function setOptions(?DatePickerOptions $options): void
    {
        $this->options = $options;
    }
}
