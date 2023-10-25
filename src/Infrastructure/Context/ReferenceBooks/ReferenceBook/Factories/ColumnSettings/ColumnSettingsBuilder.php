<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories\ColumnSettings;

use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\ColumnSettings\ColumnSettings;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\ColumnSettings\ColumnSettingsAction;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFieldGroup;

final class ColumnSettingsBuilder
{
    private ColumnSettings $columnSettings;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): self
    {
        $this->columnSettings = new ColumnSettings();

        return $this;
    }

    public function withFormSchema(?FormFieldGroup $formSchema): self
    {
        $this->columnSettings->setFormSchema($formSchema);

        return $this;
    }

    public function withAction(?ColumnSettingsAction $action): self
    {
        $this->columnSettings->setAction($action);

        return $this;
    }

    public function build(): ColumnSettings
    {
        return $this->columnSettings;
    }
}
