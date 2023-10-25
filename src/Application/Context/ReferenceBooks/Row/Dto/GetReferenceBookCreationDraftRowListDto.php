<?php

namespace Application\Context\ReferenceBooks\Row\Dto;

use Domain\Shared\ValueObjects\Id\Id;

interface GetReferenceBookCreationDraftRowListDto
{
    public function getReferenceBookCreationDraftId(): Id;

    public function getPage(): int;

    public function getPerPage(): int;
}
