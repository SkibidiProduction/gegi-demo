<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

use Domain\Shared\ValueObjects\Id\Id;

interface UnlockReferenceBookUpdateDraftDto
{
    public function getReferenceBookUpdateDraftId(): Id;
}
