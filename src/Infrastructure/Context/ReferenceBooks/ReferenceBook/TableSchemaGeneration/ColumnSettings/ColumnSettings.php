<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\ColumnSettings;

use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFieldGroup;

final class ColumnSettings
{
    private ?FormFieldGroup $formSchema = null;

    private ?ColumnSettingsAction $action = null;

    public function getFormSchema(): ?FormFieldGroup
    {
        return $this->formSchema;
    }

    public function getAction(): ?ColumnSettingsAction
    {
        return $this->action;
    }

    public function setFormSchema(?FormFieldGroup $formSchema): void
    {
        $this->formSchema = $formSchema;
    }

    public function setAction(?ColumnSettingsAction $action): void
    {
        $this->action = $action;
    }
}
