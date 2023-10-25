<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

use Domain\Shared\ValueObjects\Id\Id;

interface DeleteReferenceBookCreationDraftDto
{
    public function getId(): Id;
    public function getUserId(): ?Id;
}
