<?php

namespace Application\Context\ReferenceBooks\Column\Repositories;

use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Shared\ValueObjects\Id\Id;

interface ColumnRepository
{
    /**
     * @return Column[]
     */
    public function allByReferenceBookId(Id $referenceBookId): array;
}
