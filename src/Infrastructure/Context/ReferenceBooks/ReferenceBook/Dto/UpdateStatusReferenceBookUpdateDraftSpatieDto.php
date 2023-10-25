<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Dto;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\UpdateStatusReferenceBookUpdateDraftDto;
use Application\Shared\Dto\Trackable;
use Domain\Context\ReferenceBooks\ReferenceBook\Enums\StatusEnum;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Status\Status;
use Domain\Shared\ValueObjects\Id\Id;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class UpdateStatusReferenceBookUpdateDraftSpatieDto extends DataTransferObject implements UpdateStatusReferenceBookUpdateDraftDto, Trackable
{
    public string|Id $id;
    public string|Status $newStatusCode;

    /**
     * @throws Throwable
     */
    public function getId(): Id
    {
        if (!($this->id instanceof Id)) {
            $this->id = new Id($this->id);
        }
        return $this->id;
    }

    /**
     * @throws Throwable
     */
    public function trackData(): array
    {
        return [
            'id' => $this->getId(),
            'status' => $this->getNewStatus()->value(),
        ];
    }

    public function getNewStatus(): Status
    {
        if (!($this->newStatusCode instanceof Status)) {
            $this->newStatusCode = new Status(StatusEnum::from($this->newStatusCode));
        }
        return $this->newStatusCode;
    }
}
