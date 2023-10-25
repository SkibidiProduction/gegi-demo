<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;

interface GetByNameReferenceBookCreationDraftDto
{
    public function getName(): Name;
}
