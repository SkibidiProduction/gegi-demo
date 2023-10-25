<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\Options;

use Domain\Context\ReferenceBooks\ReferenceBook\Proxy\ValueProxy;

final class SelectOptions
{
    private ?string $placeholder = null;

    /** @var array<SelectItem>|ValueProxy $items */
    private array|ValueProxy $items = [];

    private ?string $itemText = null;

    private ?string $itemValue = null;

    private ?bool $multiple = null;

    private ?bool $rounded = null;

    private ?bool $searchable = null;

    private ?bool $appendToBody = null;

    private ?string $inputBgColor = null;

    private ?bool $clearable = null;

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
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

    public function getItemText(): ?string
    {
        return $this->itemText;
    }

    public function getItemValue(): ?string
    {
        return $this->itemValue;
    }

    public function getMultiple(): ?bool
    {
        return $this->multiple;
    }

    public function getRounded(): ?bool
    {
        return $this->rounded;
    }

    public function getSearchable(): ?bool
    {
        return $this->searchable;
    }

    public function getAppendToBody(): ?bool
    {
        return $this->appendToBody;
    }

    public function getInputBgColor(): ?string
    {
        return $this->inputBgColor;
    }

    public function getClearable(): ?bool
    {
        return $this->clearable;
    }

    public function setPlaceholder(?string $placeholder): void
    {
        $this->placeholder = $placeholder;
    }

    public function setItems(array|ValueProxy $items): void
    {
        $this->items = $items;
    }

    public function setItemText(?string $itemText): void
    {
        $this->itemText = $itemText;
    }

    public function setItemValue(?string $itemValue): void
    {
        $this->itemValue = $itemValue;
    }

    public function setMultiple(?bool $multiple): void
    {
        $this->multiple = $multiple;
    }

    public function setRounded(?bool $rounded): void
    {
        $this->rounded = $rounded;
    }

    public function setSearchable(?bool $searchable): void
    {
        $this->searchable = $searchable;
    }

    public function setAppendToBody(?bool $appendToBody): void
    {
        $this->appendToBody = $appendToBody;
    }

    public function setInputBgColor(?string $inputBgColor): void
    {
        $this->inputBgColor = $inputBgColor;
    }

    public function setClearable(?bool $clearable): void
    {
        $this->clearable = $clearable;
    }
}
