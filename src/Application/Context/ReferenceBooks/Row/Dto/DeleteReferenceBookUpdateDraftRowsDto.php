<?php

namespace Application\Context\ReferenceBooks\Row\Dto;

use Domain\Shared\ValueObjects\Id\Id;

interface DeleteReferenceBookUpdateDraftRowsDto
{
    public function getReferenceBookUpdateDraftId(): Id;

    /**
     * @return array<Id>
     */
    public function getRowIds(): array;
}
