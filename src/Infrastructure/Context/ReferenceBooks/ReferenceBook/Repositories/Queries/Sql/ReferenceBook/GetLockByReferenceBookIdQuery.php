<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Queries\Sql\ReferenceBook;

use Application\Shared\Enums\EditLockType;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookSqlRepository;

class GetLockByReferenceBookIdQuery
{
    public static function run(Id $referenceBookId): ?object
    {
        return DB::table(ReferenceBookSqlRepository::LOCKS_TABLE)
            ->where('edit_lockable_type', EditLockType::ReferenceBook->value)
            ->where('edit_lockable_id', $referenceBookId)
            ->first();
    }
}
