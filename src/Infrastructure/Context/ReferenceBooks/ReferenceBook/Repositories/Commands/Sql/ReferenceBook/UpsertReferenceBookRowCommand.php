<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBook;

use Domain\Context\ReferenceBooks\Row\Row;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Support\Facades\DB;

class UpsertReferenceBookRowCommand
{
    public static function run(Id $referenceBookId, Row $row): void
    {
        DB::table('reference_book_rows')->upsert(
            [
                'id' => $row->id()->value(),
                'reference_book_id' => $referenceBookId->value(),
            ],
            ['id'],
            ['reference_book_id'],
        );
    }
}
