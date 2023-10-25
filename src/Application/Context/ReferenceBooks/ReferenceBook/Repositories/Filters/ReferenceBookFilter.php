<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Repositories\Filters;

use Application\Shared\Criteria\Criterion;
use Application\Shared\Criteria\Filter;
use Carbon\Carbon;

interface ReferenceBookFilter extends Filter
{
    public function whereNameLike(string $partOfName): Criterion;
    public function whereDescriptionLike(string $partOfDescription): Criterion;
    public function whereStatus(string $status): Criterion;
    public function whereCreatedAtFrom(Carbon $datetime): Criterion;
    public function whereCreatedAtTo(Carbon $datetime): Criterion;
    public function whereUpdatedAtFrom(Carbon $datetime): Criterion;
    public function whereUpdatedAtTo(Carbon $datetime): Criterion;
    public function orderBy(string $field, string $direction): Criterion;
}
