<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBook;

use Application\Shared\Enums\EditLockType;
use Carbon\Carbon;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBook;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookSqlRepository;
use Throwable;

class UpsertReferenceBookEditLockCommand
{
    /**
     * @throws Throwable
     */
    public static function run(ReferenceBook $referenceBook): void
    {
        DB::table(ReferenceBookSqlRepository::LOCKS_TABLE)->upsert(
            [
                'id' => Id::new(),
                'edit_lockable_type' => EditLockType::ReferenceBookUpdateDraft->value,
                'edit_lockable_id' => $referenceBook->id()->value(),
                'user_id' => $referenceBook->lockedBy(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            ['edit_lockable_type', 'edit_lockable_id'],
            ['edit_lockable_type', 'edit_lockable_id'],
        );
    }
}
