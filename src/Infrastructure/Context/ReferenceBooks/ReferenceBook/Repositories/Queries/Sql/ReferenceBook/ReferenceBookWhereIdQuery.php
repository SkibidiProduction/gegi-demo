<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Queries\Sql\ReferenceBook;

use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookSqlRepository;

class ReferenceBookWhereIdQuery
{
    public static function run(Id $id): Builder
    {
        return DB::table(ReferenceBookSqlRepository::MAIN_TABLE)->where('id', $id);
    }
}
