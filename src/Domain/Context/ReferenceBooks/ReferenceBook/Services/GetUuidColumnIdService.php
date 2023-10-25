<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Services;

use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookColumnDoesntExistException;
use Domain\Shared\ValueObjects\Id\Id;

class GetUuidColumnIdService
{
    /**
     * @param array<Column> $columns
     * @throws ReferenceBookColumnDoesntExistException
     */
    public static function run(array $columns): Id
    {
        foreach ($columns as $column) {
            if ($column->name()->value() === Column::BASE_COLUMN_NAME) {
                return $column->id();
            }
        }

        throw new ReferenceBookColumnDoesntExistException();
    }
}
