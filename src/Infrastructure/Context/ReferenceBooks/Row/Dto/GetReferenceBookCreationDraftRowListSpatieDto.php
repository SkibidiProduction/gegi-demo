<?php

namespace Infrastructure\Context\ReferenceBooks\Row\Dto;

use Application\Context\ReferenceBooks\Row\Dto\GetReferenceBookCreationDraftRowListDto;
use Application\Shared\Dto\Trackable;
use Domain\Shared\ValueObjects\Id\Id;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class GetReferenceBookCreationDraftRowListSpatieDto extends DataTransferObject implements GetReferenceBookCreationDraftRowListDto, Trackable
{
    public string $referenceBookCreationDraftId;
    public int $page;
    public int $perPage;

    /**
     * @throws Throwable
     */
    public function getReferenceBookCreationDraftId(): Id
    {
        return new Id($this->referenceBookCreationDraftId);
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @throws Throwable
     */
    public function trackData(): array
    {
        return [
            'page' => $this->getPage(),
            'perPage' => $this->getPerPage(),
            'referenceBookId' => $this->getReferenceBookCreationDraftId()->value(),
        ];
    }
}
