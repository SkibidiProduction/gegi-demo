<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Dto;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\UnlockReferenceBookUpdateDraftDto;
use Application\Shared\Dto\Trackable;
use Domain\Shared\ValueObjects\Id\Id;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class UnlockReferenceBookUpdateDraftSpatieDto extends DataTransferObject implements UnlockReferenceBookUpdateDraftDto, Trackable
{
    public Id|string $id;

    /**
     * @throws Throwable
     */
    public function getReferenceBookUpdateDraftId(): Id
    {
        if (!$this->id instanceof Id) {
            $this->id = new Id($this->id);
        }

        return $this->id;
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function trackData(): array
    {
        return [
            'referenceBookUpdateDraftId' => $this->getReferenceBookUpdateDraftId()->value(),
        ];
    }
}
