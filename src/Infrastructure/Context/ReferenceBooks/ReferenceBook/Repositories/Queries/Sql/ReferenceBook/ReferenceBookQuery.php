<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Queries\Sql\ReferenceBook;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookSqlRepository;

class ReferenceBookQuery
{
    public static function run(): Builder
    {
        return DB::table(ReferenceBookSqlRepository::MAIN_TABLE);
    }
}
