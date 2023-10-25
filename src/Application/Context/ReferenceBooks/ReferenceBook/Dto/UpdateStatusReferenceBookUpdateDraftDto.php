<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Status\Status;
use Domain\Shared\ValueObjects\Id\Id;

interface UpdateStatusReferenceBookUpdateDraftDto
{
    public function getId(): Id;

    public function getNewStatus(): Status;
}
