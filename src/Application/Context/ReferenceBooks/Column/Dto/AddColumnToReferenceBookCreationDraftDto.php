<?php

namespace Application\Context\ReferenceBooks\Column\Dto;

use Domain\Context\ReferenceBooks\Column\ValueObjects\DataType\DataType;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Name\Name;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\Settings;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Width\Width;
use Domain\Shared\ValueObjects\Id\Id;

interface AddColumnToReferenceBookCreationDraftDto
{
    public function getReferenceBookId(): Id;
    public function getName(): Name;
    public function getWidth(): Width;
    public function getDataType(): DataType;
    public function getIsRequired(): bool;
    public function getColumnSettings(): ?Settings;
}
