<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Queries\Sql;

use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;
use Domain\Shared\Enums\DraftType;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftSqlRepository;

final class GetReferenceBookCreationDraftByNameQuery
{
    public static function run(Name $name): ?object
    {
        return DB::table(ReferenceBookCreationDraftSqlRepository::DRAFTS_TABLE)
            ->where('type', DraftType::ReferenceBookCreationDraft->value)
            ->where('name', $name->value())
            ->first();
    }
}
