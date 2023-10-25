<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql;

use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\Helpers\MapReferenceBookCreationDraftToDBStructure;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftSqlRepository;
use JsonException;

final class UpdateReferenceBookCreationDraftCommand
{
    /**
     * @throws JsonException
     */
    public static function run(ReferenceBookCreationDraft $referenceBook): void
    {
        DB::table(ReferenceBookCreationDraftSqlRepository::DRAFTS_TABLE)
            ->where('id', $referenceBook->id())
            ->update(MapReferenceBookCreationDraftToDBStructure::run($referenceBook));
    }
}
