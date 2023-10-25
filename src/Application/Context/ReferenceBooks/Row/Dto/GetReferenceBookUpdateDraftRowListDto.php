<?php

namespace Application\Context\ReferenceBooks\Row\Dto;

use Domain\Shared\ValueObjects\Id\Id;

interface GetReferenceBookUpdateDraftRowListDto
{
    public function getReferenceBookUpdateDraftId(): Id;

    public function getPage(): int;

    public function getPerPage(): int;
}
