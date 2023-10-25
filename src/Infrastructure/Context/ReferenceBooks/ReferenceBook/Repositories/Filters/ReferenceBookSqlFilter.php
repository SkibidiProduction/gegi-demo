<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Filters;

use Application\Context\ReferenceBooks\ReferenceBook\Repositories\Filters\ReferenceBookFilter;
use Application\Shared\Criteria\Criterion;
use Carbon\Carbon;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Criteria\ReferenceBook\SqlOrdered;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Criteria\ReferenceBook\SqlWhereCreatedAtFrom;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Criteria\ReferenceBook\SqlWhereCreatedAtTo;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Criteria\ReferenceBook\SqlWhereDescriptionLike;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Criteria\ReferenceBook\SqlWhereNameLike;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Criteria\ReferenceBook\SqlWhereStatus;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Criteria\ReferenceBook\SqlWhereUpdatedAtFrom;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Criteria\ReferenceBook\SqlWhereUpdatedAtTo;

class ReferenceBookSqlFilter implements ReferenceBookFilter
{
    public function whereNameLike(string $partOfName): Criterion
    {
        return new SqlWhereNameLike($partOfName);
    }

    public function whereDescriptionLike(string $partOfDescription): Criterion
    {
        return new SqlWhereDescriptionLike($partOfDescription);
    }

    public function whereStatus(string $status): Criterion
    {
        return new SqlWhereStatus($status);
    }

    public function orderBy(string $field, string $direction): Criterion
    {
        return new SqlOrdered($field, $direction);
    }

    public function whereCreatedAtFrom(Carbon $datetime): Criterion
    {
        return new SqlWhereCreatedAtFrom($datetime);
    }

    public function whereCreatedAtTo(Carbon $datetime): Criterion
    {
        return new SqlWhereCreatedAtTo($datetime);
    }

    public function whereUpdatedAtFrom(Carbon $datetime): Criterion
    {
        return new SqlWhereUpdatedAtFrom($datetime);
    }

    public function whereUpdatedAtTo(Carbon $datetime): Criterion
    {
        return new SqlWhereUpdatedAtTo($datetime);
    }
}
