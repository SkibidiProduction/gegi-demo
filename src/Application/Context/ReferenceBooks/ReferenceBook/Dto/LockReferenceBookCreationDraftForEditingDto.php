<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Shared\ValueObjects\Id\Id;

interface LockReferenceBookCreationDraftForEditingDto
{
    public function getReferenceBookCreationDraft(): ReferenceBookCreationDraft;

    public function getUserId(): Id;
}
