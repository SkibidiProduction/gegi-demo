<?php

namespace Application\Context\ReferenceBooks\Column\Factories;

use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Context\ReferenceBooks\Column\ValueObjects\DataType\DataType;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Name\Name;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\Settings;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Width\Width;
use Domain\Shared\ValueObjects\Id\Id;
use ReflectionException;

class ColumnBuilder
{
    protected Id $id;
    protected Name $name;
    protected DataType $dataType;
    protected Width $width;
    protected Id $referenceBookId;
    protected bool $required;
    protected ?Settings $settings;

    public function withId(Id $id): ColumnBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function withName(Name $name): ColumnBuilder
    {
        $this->name = $name;
        return $this;
    }

    public function withDataType(DataType $dataType): ColumnBuilder
    {
        $this->dataType = $dataType;
        return $this;
    }

    public function withWidth(Width $width): ColumnBuilder
    {
        $this->width = $width;
        return $this;
    }

    public function withReferenceBookId(Id $referenceBookId): ColumnBuilder
    {
        $this->referenceBookId = $referenceBookId;
        return $this;
    }

    public function withRequired(bool $required): ColumnBuilder
    {
        $this->required = $required;
        return $this;
    }

    public function withSettings(?Settings $settings): ColumnBuilder
    {
        $this->settings = $settings;
        return $this;
    }

    /**
     * @throws ReflectionException
     */
    public function restore(): Column
    {
        $reflection = new \ReflectionClass(Column::class);
        $column = $reflection->newInstanceWithoutConstructor();
        $reflection->getProperty('id')->setValue($column, $this->id);
        $reflection->getProperty('name')->setValue($column, $this->name);
        $reflection->getProperty('dataType')->setValue($column, $this->dataType);
        $reflection->getProperty('width')->setValue($column, $this->width);
        $reflection->getProperty('referenceBookId')->setValue($column, $this->referenceBookId);
        $reflection->getProperty('isRequired')->setValue($column, $this->required);
        $reflection->getProperty('settings')->setValue($column, $this->settings);
        return $column;
    }
}
