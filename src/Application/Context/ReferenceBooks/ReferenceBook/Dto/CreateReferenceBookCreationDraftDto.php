<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Code\Code;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;
use Domain\Shared\ValueObjects\Id\Id;

interface CreateReferenceBookCreationDraftDto
{
    public function getName(): Name;

    public function getCode(): Code;

    public function getUserId(): Id;
}
