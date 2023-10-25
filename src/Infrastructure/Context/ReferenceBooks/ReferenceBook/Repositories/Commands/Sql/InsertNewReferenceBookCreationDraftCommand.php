<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql;

use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\Helpers\MapReferenceBookCreationDraftToDBStructure;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftSqlRepository;
use JsonException;

final class InsertNewReferenceBookCreationDraftCommand
{
    /**
     * @throws JsonException
     */
    public static function run(ReferenceBookCreationDraft $referenceBook): void
    {
        DB::table(ReferenceBookCreationDraftSqlRepository::DRAFTS_TABLE)
            ->insert(MapReferenceBookCreationDraftToDBStructure::run($referenceBook));
    }
}
