<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Queries\Sql;

use Application\Shared\Enums\EditLockType;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftSqlRepository;

class GetLockByReferenceBookCreationDraftId
{
    public static function run(Id $id): ?object
    {
        return DB::table(ReferenceBookCreationDraftSqlRepository::LOCKS_TABLE)
            ->where('edit_lockable_type', EditLockType::ReferenceBookCreationDraft->value)
            ->where('edit_lockable_id', $id->value())
            ->first();
    }
}
