<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBookCreationDraft\DataMappers;

use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Context\ReferenceBooks\Row\Row;
use Domain\Shared\Enums\DraftType;
use JsonException;

class MapReferenceBookCreationDraftToDBStructure
{
    /**
     * @throws JsonException
     */
    public static function run(ReferenceBookCreationDraft $referenceBook): array
    {
        return [
            'id' => $referenceBook->id()->value(),
            'type' => DraftType::ReferenceBookCreationDraft->value,
            'name' => $referenceBook->name()->value(),
            'body' => json_encode([
                'code' => $referenceBook->code()->value(),
                'rows' => self::mapToRowsDB($referenceBook->rows()),
                'type' => $referenceBook->type()->value(),
                'status' => $referenceBook->status()->value(),
                'values' => self::mapToValuesDB($referenceBook->rows()),
                'columns' => self::mapToColumnsDB($referenceBook->columns()),
                'description' => $referenceBook->description()?->value(),
                'previous_status' => $referenceBook->statusPrevious()?->value(),
            ], JSON_THROW_ON_ERROR, JSON_UNESCAPED_UNICODE),
            'created_by' => $referenceBook->createdBy()->value(),
            'updated_by' => $referenceBook->lockedBy()?->value(),
            'created_at' => $referenceBook->createdAt()->toString(),
            'updated_at' => $referenceBook->updatedAt()?->toString(),
        ];
    }

    /**
     * @param array<Row> $rows
     * @return array
     */
    private static function mapToRowsDB(array $rows): array
    {
        return array_map(static fn (Row $row) => [
            'id' => $row->id()->value(),
        ], $rows);
    }

    /**
     * @param array<Row> $rows
     * @return array
     */
    private static function mapToValuesDB(array $rows): array
    {
        $values = [];
        foreach ($rows as $row) {
            foreach ($row->values() as $value) {
                $values[] = [
                    'reference_book_row_id' => $row->id()->value(),
                    'reference_book_column_id' => $value->columnId()->value(),
                    'value' => $value->value(),
                ];
            }
        }

        return $values;
    }

    /**
     * @param array<Column> $columns
     * @return array
     */
    private static function mapToColumnsDB(array $columns): array
    {
        return array_map(static fn (Column $column) => [
            'id' => $column->id()->value(),
            'name' => $column->name()->value(),
            'width' => $column->width()->value(),
            'required' => $column->isRequired(),
            'settings' => $column->settings()?->toArray(),
            'data_type' => $column->dataType()->value(),
        ], $columns);
    }
}
