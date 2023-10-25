<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Queries\Sql\ReferenceBook;

use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookSqlRepository;

class GetReferenceBookByIdQuery
{
    public static function run(Id $id): ?object
    {
        return DB::table(ReferenceBookSqlRepository::MAIN_TABLE)
            ->where('id', $id)
            ->first();
    }
}
