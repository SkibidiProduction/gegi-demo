<?php

namespace Domain\Context\ReferenceBooks\Column\Validators;

use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Context\ReferenceBooks\Column\Exceptions\ReferenceBookIdAlreadySetException;
use Domain\Context\ReferenceBooks\Column\Exceptions\RequiredColumnCantHaveAnEmptyValueException;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Name\Name;
use Domain\Shared\ValueObjects\Id\Id;
use Throwable;

class ColumnValidator
{
    /**
     * @throws Throwable
     */
    public function thatReferenceBookIdCantBeChangedWhenItAlreadySet(?Id $currentId, Id $newId): void
    {
        if (!is_null($currentId) && $currentId->value() !== $newId->value()) {
            throw new ReferenceBookIdAlreadySetException();
        }
    }

    /**
     * @throws RequiredColumnCantHaveAnEmptyValueException
     */
    public function thatColumnCantHaveAnEmptyValueIfItsRequiredAndNotUuid(
        bool $isRequired,
        mixed $defaultValue,
        Name $name
    ): void {
        if ($isRequired && empty($defaultValue) && $name->value() !== Column::BASE_COLUMN_NAME) {
            throw new RequiredColumnCantHaveAnEmptyValueException();
        }
    }
}
