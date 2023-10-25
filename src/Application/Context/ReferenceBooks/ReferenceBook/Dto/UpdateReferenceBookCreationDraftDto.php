<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

use Application\Context\ReferenceBooks\ReferenceBook\Enums\UpdatableValueTypeEnum;
use Domain\Shared\ValueObjects\Id\Id;

interface UpdateReferenceBookCreationDraftDto
{
    public function getId(): Id;
    public function getValueType(): UpdatableValueTypeEnum;
    public function getValue(): mixed;
}
