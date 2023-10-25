<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Criteria\ReferenceBook;

use Illuminate\Database\Query\Builder;
use Infrastructure\Shared\Repositories\SqlCriterion\SqlCriterion;

class SqlWhereDescriptionLike implements SqlCriterion
{
    protected Builder $builder;

    public function __construct(protected readonly string $partOfDescription)
    {
    }

    public function setBuilder(Builder $builder): self
    {
        $this->builder = $builder;
        return $this;
    }

    public function apply(): void
    {
        $this->builder->where('reference_books.description', 'ilike', '%' . $this->partOfDescription . '%');
    }
}
