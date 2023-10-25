<?php

namespace Application\Context\ReferenceBooks\Row\Repositories;

use Application\Shared\Criteria\Criteria;
use Application\Shared\Utilities\Paginator\Paginator;
use Domain\Context\ReferenceBooks\Row\Row;
use Domain\Context\ReferenceBooks\Row\ValueObjects\Value;
use Domain\Shared\ValueObjects\Id\Id;

interface RowRepository
{
    public function match(Criteria $criteria): RowRepository;

    public function getPaginated(int $page, int $limit, Id $referenceBookId): Paginator;

    /**
     * @return array<Row>
     */
    public function getAllByReferenceBookId(Id $referenceBookId): array;

    /**
     * @return array<Value>
     */
    public function getValuesByColumnId(Id $columnId): array;
}
