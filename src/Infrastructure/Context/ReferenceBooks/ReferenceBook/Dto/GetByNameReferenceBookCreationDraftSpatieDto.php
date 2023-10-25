<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Dto;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\GetByNameReferenceBookCreationDraftDto;
use Application\Shared\Dto\Trackable;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class GetByNameReferenceBookCreationDraftSpatieDto extends DataTransferObject implements GetByNameReferenceBookCreationDraftDto, Trackable
{
    public string|Name $name;

    /**
     * @throws Throwable
     */
    public function getName(): Name
    {
        if (!($this->name instanceof Name)) {
            $this->name = new Name($this->name);
        }
        return $this->name;
    }

    /**
     * @throws Throwable
     */
    public function trackData(): array
    {
        return [
            'name' => $this->getName(),
        ];
    }
}
