<?php

namespace Application\Context\ReferenceBooks\Column\Dto;

use Domain\Context\ReferenceBooks\Row\ValueObjects\Value;
use Domain\Shared\ValueObjects\Id\Id;

interface UpdateReferenceBookCreationDraftRowDto
{
    public function getReferenceBookCreationDraftId(): Id;

    /**
     * @return array<Value>
     */
    public function getValues(): array;
}
