<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Dto;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\GetReferenceBookCreationDraftDto;
use Application\Shared\Dto\Trackable;
use Domain\Shared\ValueObjects\Id\Id;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class GetReferenceBookCreationDraftSpatieDto extends DataTransferObject implements GetReferenceBookCreationDraftDto, Trackable
{
    public string|Id $id;

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
        ];
    }
}
