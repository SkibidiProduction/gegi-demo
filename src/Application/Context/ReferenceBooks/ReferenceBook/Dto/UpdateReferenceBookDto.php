<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

use Domain\Shared\ValueObjects\Id\Id;

interface UpdateReferenceBookDto
{
    public function getDraftId(): Id;
}
