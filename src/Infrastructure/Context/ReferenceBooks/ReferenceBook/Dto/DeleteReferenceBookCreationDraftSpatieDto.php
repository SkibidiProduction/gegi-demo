<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Dto;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\DeleteReferenceBookCreationDraftDto;
use Application\Shared\Dto\Trackable;
use Domain\Shared\ValueObjects\Id\Id;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class DeleteReferenceBookCreationDraftSpatieDto extends DataTransferObject implements DeleteReferenceBookCreationDraftDto, Trackable
{
    public Id|string $id;
    public Id|string|null $userId;

    public function trackData(): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
        ];
    }

    /**
     * @return Id|null
     * @throws Throwable
     */
    public function getUserId(): ?Id
    {
        if (is_string($this->userId)) {
            $this->userId = new Id($this->userId);
        }
        return $this->userId;
    }

    /**
     * @throws Throwable
     */
    public function getId(): Id
    {
        if (is_string($this->id)) {
            $this->id = new Id($this->id);
        }

        return $this->id;
    }
}
