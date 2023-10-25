<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields;

use Domain\Shared\ValueObjects\Id\Id;

interface FormField
{
    public function getImmediate(): ?bool;

    public function getName(): Id;

    public function getCaption(): ?string;

    public function getValueName(): Id;

    public function getItemType(): string;

    public function getClasses(): ?array;

    public function getRules(): ?string;

    public function getStyle(): ?string;

    public function getOptions(): mixed;
}
