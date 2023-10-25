<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBook;

use Domain\Context\ReferenceBooks\Row\ValueObjects\Value;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookSqlRepository;

class UpsertReferenceBookValueCommand
{
    public static function run(Value $value): void
    {
        DB::table(ReferenceBookSqlRepository::VALUES_TABLE)->upsert(
            [
                'id' => Id::new()->value(),
                'value' => $value->value(),
                'reference_book_row_id' => $value->rowId()->value(),
                'reference_book_column_id' => $value->columnId()->value(),
            ],
            ['reference_book_row_id', 'reference_book_column_id'],
            ['reference_book_row_id', 'reference_book_column_id'],
        );
    }
}
