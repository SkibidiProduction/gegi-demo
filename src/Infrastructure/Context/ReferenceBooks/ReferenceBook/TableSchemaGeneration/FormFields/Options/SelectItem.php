<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\Options;

final class SelectItem
{
    private string $text;

    private ?string $value = null;

    private ?bool $disabled = false;

    private ?string $description = null;

    private ?string $icon = null;

    public function getText(): string
    {
        return $this->text;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getDisabled(): ?bool
    {
        return $this->disabled;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setValue(?string $value): void
    {
        $this->value = $value;
    }

    public function setDisabled(?bool $disabled): void
    {
        $this->disabled = $disabled;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }
}
