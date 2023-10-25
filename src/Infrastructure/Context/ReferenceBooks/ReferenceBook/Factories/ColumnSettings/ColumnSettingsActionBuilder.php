<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories\ColumnSettings;

use Domain\Context\ReferenceBooks\ReferenceBook\Proxy\ValueProxy;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\ColumnSettings\ColumnSettingsAction;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\ColumnSettings\ColumnSettingsActionType;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\Options\SelectItem;

final class ColumnSettingsActionBuilder
{
    private ColumnSettingsAction $columnSettingsAction;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): self
    {
        $this->columnSettingsAction = new ColumnSettingsAction();

        return $this;
    }

    public function withType(ColumnSettingsActionType $type): self
    {
        $this->columnSettingsAction->setType($type);

        return $this;
    }

    /** @param array<SelectItem>|ValueProxy $items */
    public function withItems(array|ValueProxy $items): self
    {
        $this->columnSettingsAction->setItems($items);

        return $this;
    }

    public function build(): ColumnSettingsAction
    {
        return $this->columnSettingsAction;
    }
}
