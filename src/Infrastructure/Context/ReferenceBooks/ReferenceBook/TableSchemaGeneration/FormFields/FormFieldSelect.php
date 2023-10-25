<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields;

use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\Options\SelectOptions;

final class FormFieldSelect extends FormFieldBase implements FormField
{
    private ?SelectOptions $options = null;

    public function getOptions(): ?SelectOptions
    {
        return $this->options;
    }

    public function setOptions(?SelectOptions $options): void
    {
        $this->options = $options;
    }
}
