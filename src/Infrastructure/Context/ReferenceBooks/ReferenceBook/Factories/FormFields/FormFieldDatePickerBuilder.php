<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories\FormFields;

use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\FormFieldDatePicker;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\Options\DatePickerOptions;

final class FormFieldDatePickerBuilder extends FormFieldBuilder
{
    private FormFieldDatePicker $formField;

    public function reset(): self
    {
        $this->formField = new FormFieldDatePicker();

        return $this;
    }

    protected function formField(): FormFieldDatePicker
    {
        return $this->formField;
    }

    public function withOptions(?DatePickerOptions $options): self
    {
        $this->formField()->setOptions($options);

        return $this;
    }

    public function build(): FormFieldDatePicker
    {
        return $this->formField();
    }
}
