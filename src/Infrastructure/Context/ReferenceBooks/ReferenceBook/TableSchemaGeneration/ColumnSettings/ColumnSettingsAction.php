<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\ColumnSettings;

use Domain\Context\ReferenceBooks\ReferenceBook\Proxy\ValueProxy;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\Options\SelectItem;

final class ColumnSettingsAction
{
    private ColumnSettingsActionType $type;

    /** @var array<SelectItem>|ValueProxy $items */
    private array|ValueProxy $items = [];

    public function getType(): string
    {
        return $this->type->value;
    }

    public function getItems(): array
    {
        if ($this->items instanceof ValueProxy) {
            $items = [];
            $rawItems = $this->items->get();

            foreach ($rawItems as $rawItem) {
                $item = new SelectItem();
                $item->setText($rawItem->value());
                $item->setValue($rawItem->rowId()->value());
                $item->setDisabled(false);
                $item->setDescription(null);
                $item->setIcon(null);

                $items[] = $item;
            }

            $this->items = $items;
        }

        return $this->items;
    }

    public function setType(ColumnSettingsActionType $type): void
    {
        $this->type = $type;
    }

    public function setItems(array|ValueProxy $items): void
    {
        $this->items = $items;
    }
}
