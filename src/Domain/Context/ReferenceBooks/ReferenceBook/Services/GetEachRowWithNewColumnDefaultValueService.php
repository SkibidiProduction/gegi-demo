<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Services;

use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Context\ReferenceBooks\Row\Row;
use Domain\Context\ReferenceBooks\Row\ValueObjects\Value;

class GetEachRowWithNewColumnDefaultValueService
{
    /**
     * @param array<Row> $existRows
     * @param Column $newColumn
     * @return array
     */
    public static function run(array $existRows, Column $newColumn): array
    {
        $rowList = [];
        foreach ($existRows as $row) {
            $row->addValue(new Value($newColumn->defaultValue(), $newColumn->id()));
            $rowList[] = $row;
        }
        return $rowList;
    }
}
