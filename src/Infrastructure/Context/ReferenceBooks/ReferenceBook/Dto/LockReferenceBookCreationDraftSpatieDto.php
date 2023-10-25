<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Dto;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\LockReferenceBookCreationDraftDto;
use Application\Shared\Dto\Trackable;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Shared\ValueObjects\Id\Id;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class LockReferenceBookCreationDraftSpatieDto extends DataTransferObject implements LockReferenceBookCreationDraftDto, Trackable
{
    public ReferenceBookCreationDraft|string $id;

    public Id|string $userId;

    /**
     * @throws Throwable
     */
    public function getReferenceBookCreationDraftId(): Id
    {
        return new Id($this->id);
    }

    /**
     * @throws Throwable
     */
    public function getUserId(): Id
    {
        if (!$this->userId instanceof Id) {
            $this->userId = new Id($this->userId);
        }

        return $this->userId;
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function trackData(): array
    {
        return [
            'referenceBookCreationDraft' => $this->getReferenceBookCreationDraftId()->value(),
            'userId' => $this->getUserId()->value(),
        ];
    }
}
