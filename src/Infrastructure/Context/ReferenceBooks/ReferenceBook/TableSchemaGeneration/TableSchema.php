<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration;

final class TableSchema
{
    private ?string $title = null;

    /**
     * @var array<TableColumn>
     */
    private array $columns = [];

    private ?FormFieldGroup $formSchema = null;

    public function __construct()
    {
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getFormSchema(): ?FormFieldGroup
    {
        return $this->formSchema;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function addColumn(TableColumn $tableColumn): void
    {
        $this->columns[] = $tableColumn;
    }

    public function setFormSchema(?FormFieldGroup $formSchema): void
    {
        $this->formSchema = $formSchema;
    }
}
