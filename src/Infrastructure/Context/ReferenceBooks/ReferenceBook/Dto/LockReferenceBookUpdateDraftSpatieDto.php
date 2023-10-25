<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Dto;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\LockReferenceBookUpdateDraftDto;
use Application\Shared\Dto\Trackable;
use Domain\Shared\ValueObjects\Id\Id;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class LockReferenceBookUpdateDraftSpatieDto extends DataTransferObject implements LockReferenceBookUpdateDraftDto, Trackable
{
    public Id|string $id;

    public Id|string $userId;

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
            'referenceBookUpdateDraft' => $this->getReferenceBookUpdateDraftId()->value(),
            'userId' => $this->getUserId()->value(),
        ];
    }
}
