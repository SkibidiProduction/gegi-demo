<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

use Domain\Shared\ValueObjects\Id\Id;

interface UnlockReferenceBookCreationDraftDto
{
    public function getReferenceBookCreationDraftId(): Id;
}
