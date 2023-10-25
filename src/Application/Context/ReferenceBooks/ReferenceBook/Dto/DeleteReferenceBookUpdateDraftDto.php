<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

use Domain\Shared\ValueObjects\Id\Id;

interface DeleteReferenceBookUpdateDraftDto
{
    public function getId(): Id;
}
