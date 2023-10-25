<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Criteria\ReferenceBook;

use Illuminate\Database\Query\Builder;
use Infrastructure\Shared\Repositories\SqlCriterion\SqlCriterion;

class SqlOrdered implements SqlCriterion
{
    protected Builder $builder;

    public function __construct(protected readonly string $field, protected readonly string $direction)
    {
    }

    public function apply(): void
    {
        $this->builder->orderBy('reference_books.' . $this->field, $this->direction);
    }

    public function setBuilder(Builder $builder): SqlCriterion
    {
        $this->builder = $builder;
        return $this;
    }
}
