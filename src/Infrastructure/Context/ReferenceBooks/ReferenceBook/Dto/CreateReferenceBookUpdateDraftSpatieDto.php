<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Dto;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\CreateReferenceBookUpdateDraftDto;
use Application\Shared\Dto\Trackable;
use Domain\Shared\ValueObjects\Id\Id;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class CreateReferenceBookUpdateDraftSpatieDto extends DataTransferObject implements CreateReferenceBookUpdateDraftDto, Trackable
{
    public string|Id $id;

    /**
     * @throws Throwable
     */
    public function trackData(): array
    {
        return [
            'id' => $this->getId(),
        ];
    }

    /**
     * @throws Throwable
     */
    public function getId(): Id
    {
        if (!$this->id instanceof Id) {
            $this->id = new Id($this->id);
        }

        return $this->id;
    }
}
