<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\Options;

use Domain\Context\ReferenceBooks\Column\ValueObjects\DataType\DataType;

final class InputOptions
{
    private ?DataType $type = null;

    private ?string $placeholder = null;

    private ?bool $clearable = null;

    private ?string $size = null;

    private ?bool $rounded = null;

    private ?string $bgColor = null;

    public function getType(): ?DataType
    {
        return $this->type;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function getClearable(): ?bool
    {
        return $this->clearable;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function getRounded(): ?bool
    {
        return $this->rounded;
    }

    public function getBgColor(): ?string
    {
        return $this->bgColor;
    }

    public function setType(?DataType $type): void
    {
        $this->type = $type;
    }

    public function setPlaceholder(?string $placeholder): void
    {
        $this->placeholder = $placeholder;
    }

    public function setClearable(?bool $clearable): void
    {
        $this->clearable = $clearable;
    }

    public function setSize(?string $size): void
    {
        $this->size = $size;
    }

    public function setRounded(?bool $rounded): void
    {
        $this->rounded = $rounded;
    }

    public function setBgColor(?string $bgColor): void
    {
        $this->bgColor = $bgColor;
    }
}
