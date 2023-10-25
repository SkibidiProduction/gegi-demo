<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Criteria\ReferenceBook;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Infrastructure\Shared\Repositories\SqlCriterion\SqlCriterion;

class SqlWhereCreatedAtFrom implements SqlCriterion
{
    protected Builder $builder;

    public function __construct(protected readonly Carbon $datetime)
    {
    }

    public function apply(): void
    {
        $this->builder->where('reference_books.created_at', '>=', $this->datetime);
    }

    public function setBuilder(Builder $builder): SqlCriterion
    {
        $this->builder = $builder;
        return $this;
    }
}
