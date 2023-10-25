<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBook;

use Application\Shared\Enums\EditLockType;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Support\Facades\DB;

class DeleteReferenceBookEditLockCommand
{
    public static function run(Id $referenceBookId): void
    {
        DB::table('edit_locks')
            ->where('edit_lockable_type', EditLockType::ReferenceBookUpdateDraft->value)
            ->where('edit_lockable_id', $referenceBookId->value())
            ->delete();
    }
}
