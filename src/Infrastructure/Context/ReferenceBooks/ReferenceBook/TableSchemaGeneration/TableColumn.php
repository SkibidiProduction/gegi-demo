<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration;

use Domain\Context\ReferenceBooks\Column\ValueObjects\DataType\DataType;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Name\Name;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Width\Width;
use Domain\Shared\ValueObjects\Id\Id;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\ColumnSettings\ColumnSettings;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\Filters\ColumnFilter;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\Link\LinkType;

final class TableColumn
{
    private Id $key;

    private Name $label;

    private ?Width $width = null;

    private ?ColumnSettings $columnSettings = null;

    private ?DataType $type = null;

    private ?string $formatType = null;

    private ?bool $range = false;

    private ?LinkType $linkType = null;

    private ?bool $sort = false;

    private ?ColumnFilter $columnFilter = null;

    private bool $isRequired = false;

    public function getKey(): Id
    {
        return $this->key;
    }

    public function getLabel(): Name
    {
        return $this->label;
    }

    public function getWidth(): ?int
    {
        return $this->width?->value();
    }

    public function getColumnSettings(): ?ColumnSettings
    {
        return $this->columnSettings;
    }

    public function getType(): ?string
    {
        return $this->type?->value();
    }

    public function getFormatType(): ?string
    {
        return $this->formatType;
    }

    public function getRange(): ?bool
    {
        return $this->range;
    }

    public function getLinkType(): ?LinkType
    {
        return $this->linkType;
    }

    public function getSort(): ?bool
    {
        return $this->sort;
    }

    public function getColumnFilter(): ?ColumnFilter
    {
        return $this->columnFilter;
    }

    public function isRequired(): bool
    {
        return $this->isRequired;
    }

    public function setKey(Id $key): void
    {
        $this->key = $key;
    }

    public function setLabel(Name $label): void
    {
        $this->label = $label;
    }

    public function setWidth(?Width $width): void
    {
        $this->width = $width;
    }

    public function setColumnSettings(?ColumnSettings $columnSettings): void
    {
        $this->columnSettings = $columnSettings;
    }

    public function setType(?DataType $type): void
    {
        $this->type = $type;
    }

    public function setFormatType(?string $formatType): void
    {
        $this->formatType = $formatType;
    }

    public function setRange(?bool $range): void
    {
        $this->range = $range;
    }

    public function setLinkType(?LinkType $linkType): void
    {
        $this->linkType = $linkType;
    }

    public function setSort(?bool $sort): void
    {
        $this->sort = $sort;
    }

    public function setColumnFilter(?ColumnFilter $columnFilter): void
    {
        $this->columnFilter = $columnFilter;
    }

    public function setIsRequired(bool $isRequired): void
    {
        $this->isRequired = $isRequired;
    }
}
