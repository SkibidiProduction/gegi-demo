<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields;

use Domain\Shared\ValueObjects\Id\Id;

abstract class FormFieldBase implements FormField
{
    private ?bool $immediate = null;

    private Id $name;

    private ?string $caption = null;

    private Id $valueName;

    private ItemType $itemType;

    /** @var string[]|null  */
    private ?array $classes = null;

    private ?string $rules = null;

    private ?string $style = null;

    public function getImmediate(): ?bool
    {
        return $this->immediate;
    }

    public function getName(): Id
    {
        return $this->name;
    }

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function getValueName(): Id
    {
        return $this->valueName;
    }

    public function getItemType(): string
    {
        return $this->itemType->value;
    }

    public function getClasses(): ?array
    {
        return $this->classes;
    }

    public function getRules(): ?string
    {
        return $this->rules;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setImmediate(?bool $immediate): void
    {
        $this->immediate = $immediate;
    }

    public function setName(Id $name): void
    {
        $this->name = $name;
    }

    public function setCaption(?string $caption): void
    {
        $this->caption = $caption;
    }

    public function setValueName(Id $valueName): void
    {
        $this->valueName = $valueName;
    }

    public function setItemType(ItemType $itemType): void
    {
        $this->itemType = $itemType;
    }

    public function setClasses(?array $classes): void
    {
        $this->classes = $classes;
    }

    public function setRules(?string $rules): void
    {
        $this->rules = $rules;
    }

    public function setStyle(?string $style): void
    {
        $this->style = $style;
    }
}
