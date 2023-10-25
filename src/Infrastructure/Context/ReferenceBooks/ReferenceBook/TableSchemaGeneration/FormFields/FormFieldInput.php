<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields;

use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\Options\InputOptions;

final class FormFieldInput extends FormFieldBase implements FormField
{
    private ?InputOptions $options = null;

    public function getOptions(): ?InputOptions
    {
        return $this->options;
    }

    public function setOptions(?InputOptions $options): void
    {
        $this->options = $options;
    }
}
