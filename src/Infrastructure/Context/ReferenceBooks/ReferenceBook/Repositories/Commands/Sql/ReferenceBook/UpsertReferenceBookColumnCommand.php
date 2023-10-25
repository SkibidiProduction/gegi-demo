<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBook;

use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\Settings;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookSqlRepository;
use JsonException;

class UpsertReferenceBookColumnCommand
{
    /**
     * @throws JsonException
     */
    public static function run(Id $referenceBookId, Column $column): void
    {
        if (is_null($column->settings())) {
            $settings = null;
        } else {
            /** @var Settings $columnSettings */
            $columnSettings = $column->settings();
            $settings = json_encode(
                $columnSettings->toArray(),
                JSON_THROW_ON_ERROR
            );
        }

        DB::table(ReferenceBookSqlRepository::COLUMNS_TABLE)->upsert(
            [
                'id' => $column->id()->value(),
                'name' => $column->name()->value(),
                'data_type' => $column->dataType()->value(),
                'reference_book_id' => $referenceBookId->value(),
                'width' => $column->width()->value(),
                'required' => $column->isRequired(),
                'settings' => $settings,
            ],
            ['id'],
            ['name', 'data_type', 'reference_book_id', 'width', 'required', 'settings']
        );
    }
}
