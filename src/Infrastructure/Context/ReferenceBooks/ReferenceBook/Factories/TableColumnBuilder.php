<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories;

use Domain\Context\ReferenceBooks\Column\ValueObjects\DataType\DataType;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Name\Name;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Width\Width;
use Domain\Shared\ValueObjects\Id\Id;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\ColumnSettings\ColumnSettings;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\Filters\ColumnFilter;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\Link\LinkType;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\TableColumn;

final class TableColumnBuilder
{
    private TableColumn $tableColumn;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): self
    {
        $this->tableColumn = new TableColumn();

        return $this;
    }

    public function withKey(Id $key): self
    {
        $this->tableColumn->setKey($key);

        return $this;
    }

    public function withLabel(Name $label): self
    {
        $this->tableColumn->setLabel($label);

        return $this;
    }

    public function withWidth(?Width $width): self
    {
        $this->tableColumn->setWidth($width);

        return $this;
    }

    public function withColumnSettings(?ColumnSettings $columnSettings): self
    {
        $this->tableColumn->setColumnSettings($columnSettings);

        return $this;
    }

    public function withType(?DataType $type): self
    {
        $this->tableColumn->setType($type);

        return $this;
    }

    public function withFormatType(?string $formatType): self
    {
        $this->tableColumn->setFormatType($formatType);

        return $this;
    }

    public function withRange(?bool $range): self
    {
        $this->tableColumn->setRange($range);

        return $this;
    }

    public function withLinkType(?LinkType $linkType): self
    {
        $this->tableColumn->setLinkType($linkType);

        return $this;
    }

    public function withSort(?bool $sort): self
    {
        $this->tableColumn->setSort($sort);

        return $this;
    }

    public function withColumnFilter(?ColumnFilter $columnFilter): self
    {
        $this->tableColumn->setColumnFilter($columnFilter);

        return $this;
    }

    public function withIsRequired(bool $isRequired): self
    {
        $this->tableColumn->setIsRequired($isRequired);

        return $this;
    }

    public function build(): TableColumn
    {
        return $this->tableColumn;
    }
}
