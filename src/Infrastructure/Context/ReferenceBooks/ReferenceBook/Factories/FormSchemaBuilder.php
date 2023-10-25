<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories;

use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFieldGroup;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\FormField;

final class FormSchemaBuilder
{
    private FormFieldGroup $formSchema;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): self
    {
        $this->formSchema = new FormFieldGroup();

        return $this;
    }

    public function withName(?string $name): self
    {
        $this->formSchema->setName($name);

        return $this;
    }

    public function withTitle(?string $title): self
    {
        $this->formSchema->setTitle($title);

        return $this;
    }

    public function withHint(?string $hint): self
    {
        $this->formSchema->setHint($hint);

        return $this;
    }

    public function withMaxLength(?int $maxLength): self
    {
        $this->formSchema->setMaxLength($maxLength);

        return $this;
    }

    public function withGroupClass(?string $groupClass): self
    {
        $this->formSchema->setGroupClass($groupClass);

        return $this;
    }

    public function withErrorMessage(?string $errorMessage): self
    {
        $this->formSchema->setErrorMessage($errorMessage);

        return $this;
    }

    /** @param array<FormField> $fields */
    public function withFields(array $fields): self
    {
        $this->formSchema->setFields($fields);

        return $this;
    }

    public function withVisible(?bool $visible): self
    {
        $this->formSchema->setVisible($visible);

        return $this;
    }

    public function build(): FormFieldGroup
    {
        return $this->formSchema;
    }
}
