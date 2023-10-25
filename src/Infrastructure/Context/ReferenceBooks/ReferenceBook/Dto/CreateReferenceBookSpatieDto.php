<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Dto;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\CreateReferenceBookDto;
use Application\Shared\Dto\Trackable;
use Domain\Shared\ValueObjects\Id\Id;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class CreateReferenceBookSpatieDto extends DataTransferObject implements CreateReferenceBookDto, Trackable
{
    public string|Id $draftId;

    /**
     * @throws Throwable
     */
    public function getDraftId(): Id
    {
        if (!$this->draftId instanceof Id) {
            $this->draftId = new Id($this->draftId);
        }

        return $this->draftId;
    }

    /**
     * @throws Throwable
     */
    public function trackData(): array
    {
        return [
            'draftId' => $this->getDraftId()->value(),
        ];
    }
}
