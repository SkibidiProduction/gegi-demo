<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

use Domain\Shared\ValueObjects\Id\Id;

interface GetReferenceBookCreationDraftDto
{
    public function getId(): Id;
}
