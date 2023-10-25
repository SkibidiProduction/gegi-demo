<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories\FormFields;

use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\FormFieldInput;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\Options\InputOptions;

final class FormFieldInputBuilder extends FormFieldBuilder
{
    private FormFieldInput $formField;

    public function reset(): self
    {
        $this->formField = new FormFieldInput();

        return $this;
    }

    protected function formField(): FormFieldInput
    {
        return $this->formField;
    }

    public function withOptions(?InputOptions $options): self
    {
        $this->formField()->setOptions($options);

        return $this;
    }

    public function build(): FormFieldInput
    {
        return $this->formField();
    }
}
