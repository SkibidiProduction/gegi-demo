<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories\FormFields\Options;

use Domain\Context\ReferenceBooks\ReferenceBook\Proxy\ValueProxy;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\Options\SelectItem;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\Options\SelectOptions;

final class SelectOptionsBuilder
{
    private SelectOptions $selectOptions;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): self
    {
        $this->selectOptions = new SelectOptions();

        return $this;
    }

    public function withPlaceholder(?string $placeholder): self
    {
        $this->selectOptions->setPlaceholder($placeholder);

        return $this;
    }

    /** @param SelectItem[]|ValueProxy $items */
    public function withItems(array|ValueProxy $items): self
    {
        $this->selectOptions->setItems($items);

        return $this;
    }

    public function withItemText(?string $itemText): self
    {
        $this->selectOptions->setItemText($itemText);

        return $this;
    }

    public function withItemValue(?string $itemValue): self
    {
        $this->selectOptions->setItemValue($itemValue);

        return $this;
    }

    public function withMultiple(?bool $multiple): self
    {
        $this->selectOptions->setMultiple($multiple);

        return $this;
    }

    public function withRounded(?bool $rounded): self
    {
        $this->selectOptions->setRounded($rounded);

        return $this;
    }

    public function withSearchable(?bool $searchable): self
    {
        $this->selectOptions->setSearchable($searchable);

        return $this;
    }

    public function withAppendToBody(?bool $appendToBody): self
    {
        $this->selectOptions->setAppendToBody($appendToBody);

        return $this;
    }

    public function withInputBgColor(?string $inputBgColor): self
    {
        $this->selectOptions->setInputBgColor($inputBgColor);

        return $this;
    }

    public function withClearable(?bool $clearable): self
    {
        $this->selectOptions->setClearable($clearable);

        return $this;
    }

    public function build(): SelectOptions
    {
        return $this->selectOptions;
    }
}
