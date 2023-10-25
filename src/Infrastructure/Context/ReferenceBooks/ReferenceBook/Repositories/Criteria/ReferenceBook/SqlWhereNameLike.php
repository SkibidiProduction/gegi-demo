<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Criteria\ReferenceBook;

use Illuminate\Database\Query\Builder;
use Infrastructure\Shared\Repositories\SqlCriterion\SqlCriterion;

class SqlWhereNameLike implements SqlCriterion
{
    protected Builder $builder;

    public function __construct(protected readonly string $partOfName)
    {
    }

    public function setBuilder(Builder $builder): self
    {
        $this->builder = $builder;
        return $this;
    }

    public function apply(): void
    {
        $this->builder->where('reference_books.name', 'ilike', '%' . $this->partOfName . '%');
    }
}
