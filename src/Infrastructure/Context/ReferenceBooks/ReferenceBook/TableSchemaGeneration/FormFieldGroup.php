<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration;

use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\FormField;

final class FormFieldGroup
{
    public const EXCLUDED_FIELDS = [
        'UUID',
    ];

    private ?string $name = null;

    private ?string $title = null;

    private ?string $hint = null;

    private ?int $maxLength = null;

    private ?string $groupClass = null;

    private ?string $errorMessage = null;

    /** @var array<FormField> $fields */
    private array $fields = [];

    private ?bool $visible = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getHint(): ?string
    {
        return $this->hint;
    }

    public function getMaxLength(): ?int
    {
        return $this->maxLength;
    }

    public function getGroupClass(): ?string
    {
        return $this->groupClass;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function setHint(?string $hint): void
    {
        $this->hint = $hint;
    }

    public function setMaxLength(?int $maxLength): void
    {
        $this->maxLength = $maxLength;
    }

    public function setGroupClass(?string $groupClass): void
    {
        $this->groupClass = $groupClass;
    }

    public function setErrorMessage(?string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }

    /** @param array<FormField> $fields */
    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

    public function setVisible(?bool $visible): void
    {
        $this->visible = $visible;
    }
}
