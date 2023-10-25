<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql;

use Application\Shared\Enums\EditLockType;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftSqlRepository;
use Throwable;

class UnlockReferenceBookCreationDraftCommand
{
    /**
     * @throws Throwable
     */
    public static function run(Id $id): void
    {
        DB::table(ReferenceBookCreationDraftSqlRepository::LOCKS_TABLE)
            ->where('edit_lockable_type', EditLockType::ReferenceBookCreationDraft->value)
            ->where('edit_lockable_id', $id->value())
            ->delete();
    }
}
