<?php

namespace Application\Context\ReferenceBooks\Column\Repositories;

use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Shared\ValueObjects\Id\Id;

interface ColumnUpdateDraftRepository
{
    /**
     * @return array<Column>
     */
    public function allByReferenceBookId(Id $referenceBookId): array;
}
