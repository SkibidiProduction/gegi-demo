<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBookCreationDraft;

use Application\Shared\Enums\EditLockType;
use Carbon\Carbon;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftSqlRepository;
use Throwable;

class LockReferenceBookCreationDraftCommand
{
    /**
     * @throws Throwable
     */
    public static function run(ReferenceBookCreationDraft $referenceBookCreationDraft): void
    {
        DB::table(ReferenceBookCreationDraftSqlRepository::LOCKS_TABLE)->upsert(
            [
                'id' => Id::new(),
                'edit_lockable_type' => EditLockType::ReferenceBookCreationDraft->value,
                'edit_lockable_id' => $referenceBookCreationDraft->id()->value(),
                'user_id' => $referenceBookCreationDraft->lockedBy(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            ['edit_lockable_type', 'edit_lockable_id'],
            ['edit_lockable_type', 'edit_lockable_id'],
        );
    }
}
