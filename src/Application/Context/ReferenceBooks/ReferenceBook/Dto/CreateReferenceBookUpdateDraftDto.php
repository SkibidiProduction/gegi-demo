<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

use Domain\Shared\ValueObjects\Id\Id;

interface CreateReferenceBookUpdateDraftDto
{
    public function getId(): Id;
}
