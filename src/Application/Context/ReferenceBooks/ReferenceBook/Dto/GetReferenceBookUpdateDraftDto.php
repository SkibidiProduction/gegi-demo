<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

use Domain\Shared\ValueObjects\Id\Id;

interface GetReferenceBookUpdateDraftDto
{
    public function getId(): Id;
}
