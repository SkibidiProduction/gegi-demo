<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Dto;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\UnlockReferenceBookCreationDraftDto;
use Application\Shared\Dto\Trackable;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Shared\ValueObjects\Id\Id;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class UnlockReferenceBookCreationDraftSpatieDto extends DataTransferObject implements UnlockReferenceBookCreationDraftDto, Trackable
{
    public ReferenceBookCreationDraft|string $id;

    /**
     * @throws Throwable
     */
    public function getReferenceBookCreationDraftId(): Id
    {
        return new Id($this->id);
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function trackData(): array
    {
        return [
            'referenceBookCreationDraft' => $this->getReferenceBookCreationDraftId()->value(),
        ];
    }
}
