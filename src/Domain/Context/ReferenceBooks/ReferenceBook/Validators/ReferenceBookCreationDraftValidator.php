<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Validators;

use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Context\ReferenceBooks\Column\Enums\DataTypeEnum;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\NumericSettings;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\StringSettings;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\CantAddRowWithNonExistingColumnException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookColumnAlreadyExistsException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowAlreadyExistsException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowNumericValueHasIncorrectFormatException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowStringValueHasIncorrectFormatException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowValuesHasWrongNumberException;
use Domain\Context\ReferenceBooks\Row\Row;
use Domain\Context\ReferenceBooks\Row\ValueObjects\Value;
use Domain\Shared\ValueObjects\Id\Id;
use Throwable;

class ReferenceBookCreationDraftValidator
{
    /**
     * @param array<Column> $existColumns
     * @param Column $newColumn
     * @return void
     * @throws ReferenceBookColumnAlreadyExistsException
     */
    public function thatNewColumnIsUnique(array $existColumns, Column $newColumn): void
    {
        foreach ($existColumns as $existColumn) {
            if ($newColumn->id()->value() === $existColumn->id()->value()
                || $newColumn->name()->value() === $existColumn->name()->value()) {
                throw new ReferenceBookColumnAlreadyExistsException();
            }
        }
    }

    /**
     * @throws ReferenceBookRowValuesHasWrongNumberException
     */
    public function thatRowContainsAsManyElementsAsThereAreColumns(Row $row, int $columnsCount): void
    {
        if (count($row->values()) !== $columnsCount) {
            throw new ReferenceBookRowValuesHasWrongNumberException();
        }
    }

    /**
     * @param Row $row
     * @param array<Column> $columns
     * @param ?Id $uuidColumnId
     * @return void
     * @throws ReferenceBookRowNumericValueHasIncorrectFormatException
     * @throws ReferenceBookRowStringValueHasIncorrectFormatException
     * @throws Throwable
     */
    public function thatRowContainsCorrectValues(Row $row, array $columns, ?Id $uuidColumnId = null): void
    {
        foreach ($row->values() as $rowValue) {
            if (!is_null($uuidColumnId) && $rowValue->columnId()->value() === $uuidColumnId->value()) {
                continue;
            }
            foreach ($columns as $column) {
                if ($this->isRowValueAndColumnAreCompatible($rowValue, $column)) {
                    $this->checkColumnValueRequirements($rowValue, $column);
                }
            }
        }
    }

    /**
     * @param Row $row
     * @param array<Row> $existRows
     * @return void
     * @throws ReferenceBookRowAlreadyExistsException
     */
    public function thatThereIsNoSuchRowYet(Row $row, array $existRows): void
    {
        foreach ($existRows as $existRow) {
            if ($existRow->id()->value() === $row->id()->value()) {
                throw new ReferenceBookRowAlreadyExistsException();
            }
        }
    }

    /**
     * @param Row $row
     * @param array<Column> $existingColumns
     * @return void
     * @throws CantAddRowWithNonExistingColumnException
     */
    public function thatEveryColumnExists(Row $row, array $existingColumns): void
    {
        foreach ($row->values() as $rowValue) {
            $valueColumnIdExists = false;
            foreach ($existingColumns as $existColumn) {
                if ($rowValue->columnId()->value() === $existColumn->id()->value()) {
                    $valueColumnIdExists = true;
                }
            }
            if (!$valueColumnIdExists) {
                throw new CantAddRowWithNonExistingColumnException();
            }
        }
    }

    /**
     * @throws ReferenceBookRowNumericValueHasIncorrectFormatException
     * @throws ReferenceBookRowStringValueHasIncorrectFormatException
     * @throws Throwable
     */
    public function checkColumnValueRequirements(Value $rowValue, Column $column): void
    {
        if ($this->isColumnString($column)) {
            $this->checkThatRowStringValueMatchesParametersOfStringColumn($rowValue, $column);
        }
        if ($this->isColumnNumeric($column)) {
            $this->checkThatRowNumericValueMatchesParametersOfNumericColumn($rowValue, $column);
        }
        if ($this->isColumnEnum($column)) {
            $this->checkThatRowEnumValueMatchesParametersOfEnumColumn($rowValue);
        }
    }

    private function isRowValueAndColumnAreCompatible(Value $rowValue, Column $column): bool
    {
        return $rowValue->columnId()->value() === $column->id()->value();
    }

    private function isColumnString(Column $column): bool
    {
        return $column->dataType()->asEnum() === DataTypeEnum::String;
    }

    private function isColumnNumeric(Column $column): bool
    {
        return $column->dataType()->asEnum() === DataTypeEnum::Numeric;
    }

    private function isColumnEnum(Column $column): bool
    {
        return $column->dataType()->asEnum() === DataTypeEnum::Enum;
    }

    /**
     * @throws ReferenceBookRowStringValueHasIncorrectFormatException
     */
    private function checkThatRowStringValueMatchesParametersOfStringColumn(Value $rowValue, Column $column): void
    {
        /** @var StringSettings $setting */
        $setting = $column->settings();
        if (mb_strlen($rowValue->value()) < $setting->minCharactersNumber()
            || mb_strlen($rowValue->value()) > $setting->maxCharactersNumber()) {
            throw new ReferenceBookRowStringValueHasIncorrectFormatException(
                $setting->minCharactersNumber(),
                $setting->maxCharactersNumber(),
                $rowValue->columnId()->value()
            );
        }
    }

    /**
     * @throws ReferenceBookRowNumericValueHasIncorrectFormatException
     */
    private function checkThatRowNumericValueMatchesParametersOfNumericColumn(Value $rowValue, Column $column): void
    {
        /** @var NumericSettings $setting */
        $setting = $column->settings();
        if ($rowValue->value() < $setting->min()
            || $rowValue->value() > $setting->max()) {
            throw new ReferenceBookRowNumericValueHasIncorrectFormatException(
                $setting->min(),
                $setting->max(),
                $rowValue->columnId()->value()
            );
        }
    }

    /**
     * @throws Throwable
     */
    private function checkThatRowEnumValueMatchesParametersOfEnumColumn(Value $rowValue): void
    {
        new Id($rowValue->value());
    }
}
