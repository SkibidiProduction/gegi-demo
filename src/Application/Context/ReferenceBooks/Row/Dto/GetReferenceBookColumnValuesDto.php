<?php

namespace Application\Context\ReferenceBooks\Row\Dto;

use Domain\Shared\ValueObjects\Id\Id;

interface GetReferenceBookColumnValuesDto
{
    public function getId(): Id;
}
