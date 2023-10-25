<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBookCreationDraft;

use Domain\Shared\Enums\DraftType;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftSqlRepository;

class DeleteReferenceBookCreationDraftCommand
{
    public static function run(Id $id): void
    {
        DB::table(ReferenceBookCreationDraftSqlRepository::DRAFTS_TABLE)
            ->where('id', $id->value())
            ->where('type', DraftType::ReferenceBookCreationDraft->value)
            ->delete();
    }
}
