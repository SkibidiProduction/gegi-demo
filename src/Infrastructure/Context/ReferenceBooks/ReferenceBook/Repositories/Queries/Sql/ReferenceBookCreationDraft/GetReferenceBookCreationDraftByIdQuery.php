<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Queries\Sql\ReferenceBookCreationDraft;

use Domain\Shared\Enums\DraftType;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftSqlRepository;

final class GetReferenceBookCreationDraftByIdQuery
{
    public static function run(Id $id): ?object
    {
        return DB::table(ReferenceBookCreationDraftSqlRepository::DRAFTS_TABLE)
            ->where('type', DraftType::ReferenceBookCreationDraft->value)
            ->where('id', $id->value())
            ->first();
    }
}
