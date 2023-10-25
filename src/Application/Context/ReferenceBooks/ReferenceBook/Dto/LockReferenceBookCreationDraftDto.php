<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

use Domain\Shared\ValueObjects\Id\Id;

interface LockReferenceBookCreationDraftDto
{
    public function getReferenceBookCreationDraftId(): Id;

    public function getUserId(): Id;
}
