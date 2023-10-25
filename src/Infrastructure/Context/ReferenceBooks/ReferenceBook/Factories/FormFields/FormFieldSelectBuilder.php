<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories\FormFields;

use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\FormFieldSelect;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\Options\SelectOptions;

final class FormFieldSelectBuilder extends FormFieldBuilder
{
    private FormFieldSelect $formField;

    public function reset(): self
    {
        $this->formField = new FormFieldSelect();

        return $this;
    }

    protected function formField(): FormFieldSelect
    {
        return $this->formField;
    }

    public function withOptions(?SelectOptions $options): self
    {
        $this->formField()->setOptions($options);

        return $this;
    }

    public function build(): FormFieldSelect
    {
        return $this->formField();
    }
}
