<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

use Domain\Shared\ValueObjects\Id\Id;

interface LockReferenceBookUpdateDraftDto
{
    public function getReferenceBookUpdateDraftId(): Id;

    public function getUserId(): Id;
}
