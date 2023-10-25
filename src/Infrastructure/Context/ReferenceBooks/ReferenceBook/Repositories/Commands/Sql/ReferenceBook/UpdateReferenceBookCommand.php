<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBook;

use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBook;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookSqlRepository;

class UpdateReferenceBookCommand
{
    public static function run(ReferenceBook $referenceBook): void
    {
        DB::table(ReferenceBookSqlRepository::MAIN_TABLE)
            ->where('id', $referenceBook->id()->value())
            ->update([
                'name' => $referenceBook->name()->value(),
                'code' => $referenceBook->code()->value(),
                'type' => $referenceBook->type()->value(),
                'description' => $referenceBook->description()?->value(),
                'status' => $referenceBook->status()->value(),
                'current_status_set_at' => $referenceBook->status()->setAt()?->toString(),
                'current_status_set_by' => $referenceBook->status()->setBy(),
                'previous_status' => $referenceBook->statusPrevious()?->value(),
                'previous_status_set_at' => $referenceBook->statusPrevious()?->setAt()?->toString(),
                'previous_status_set_by' => $referenceBook->statusPrevious()?->setBy(),
                'created_by' => $referenceBook->createdBy()?->value(),
                'updated_by' => $referenceBook->updatedBy()?->value(),
                'created_at' => $referenceBook->createdAt(),
                'updated_at' => $referenceBook->updatedAt(),
            ]);
    }
}
