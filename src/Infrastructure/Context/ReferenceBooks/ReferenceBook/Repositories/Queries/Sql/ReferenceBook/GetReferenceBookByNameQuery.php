<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Queries\Sql\ReferenceBook;

use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookSqlRepository;

class GetReferenceBookByNameQuery
{
    public static function run(Name $name): ?object
    {
        return DB::table(ReferenceBookSqlRepository::MAIN_TABLE)
            ->where('name', $name)
            ->first();
    }
}
