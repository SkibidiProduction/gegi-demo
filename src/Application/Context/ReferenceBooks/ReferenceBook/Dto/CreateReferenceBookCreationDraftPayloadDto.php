<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Shared\ValueObjects\Id\Id;
use Infrastructure\Shared\Problems\Problem;

interface CreateReferenceBookCreationDraftPayloadDto
{
    public function getRecordId(): ?Id;

    public function getRecord(): ?ReferenceBookCreationDraft;

    /**
     * @return array<Problem>|null
     */
    public function getErrors(): ?array;
}
