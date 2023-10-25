<?php

namespace Application\Context\ReferenceBooks\Row\Dto;

use Domain\Shared\ValueObjects\Id\Id;

interface GetReferenceBookRowListDto
{
    public function getReferenceBookId(): Id;

    public function getPage(): int;

    public function getPerPage(): int;
}
