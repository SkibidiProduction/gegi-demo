<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

use Domain\Shared\ValueObjects\Id\Id;

interface CreateReferenceBookDto
{
    public function getDraftId(): Id;
}
