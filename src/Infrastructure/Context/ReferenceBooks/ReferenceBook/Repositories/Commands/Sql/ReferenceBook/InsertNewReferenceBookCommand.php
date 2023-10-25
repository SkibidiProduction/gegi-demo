<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBook;

use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBook;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookSqlRepository;

class InsertNewReferenceBookCommand
{
    public static function run(ReferenceBook $referenceBook): void
    {
        DB::table(ReferenceBookSqlRepository::MAIN_TABLE)->insert([
            'id' => $referenceBook->id()->value(),
            'name' => $referenceBook->name()->value(),
            'code' => $referenceBook->code()->value(),
            'type' => $referenceBook->type()->value(),
            'description' => $referenceBook->description()?->value(),
            'status' => $referenceBook->status()->value(),
            'previous_status' => $referenceBook->statusPrevious()?->value(),
            'created_by' => $referenceBook->createdBy()?->value(),
            'updated_by' => $referenceBook->updatedBy()?->value(),
            'created_at' => $referenceBook->createdAt(),
            'updated_at' => $referenceBook->updatedAt(),
        ]);
    }
}
