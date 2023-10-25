<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories\FormFields\Options;

use Domain\Context\ReferenceBooks\Column\ValueObjects\DataType\DataType;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\Options\InputOptions;

final class InputOptionsBuilder
{
    private InputOptions $inputOptions;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): self
    {
        $this->inputOptions = new InputOptions();

        return $this;
    }

    public function withType(?DataType $type): self
    {
        $this->inputOptions->setType($type);

        return $this;
    }

    public function withPlaceholder(?string $placeholder): self
    {
        $this->inputOptions->setPlaceholder($placeholder);

        return $this;
    }

    public function withClearable(?bool $clearable): self
    {
        $this->inputOptions->setClearable($clearable);

        return $this;
    }

    public function withSize(?string $size): self
    {
        $this->inputOptions->setSize($size);

        return $this;
    }

    public function withRounded(?bool $rounded): self
    {
        $this->inputOptions->setRounded($rounded);

        return $this;
    }

    public function withBgColor(?string $bgColor): self
    {
        $this->inputOptions->setBgColor($bgColor);

        return $this;
    }

    public function build(): InputOptions
    {
        return $this->inputOptions;
    }
}
