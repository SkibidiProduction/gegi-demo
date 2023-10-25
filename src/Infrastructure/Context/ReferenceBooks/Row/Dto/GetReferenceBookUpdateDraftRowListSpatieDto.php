<?php

namespace Infrastructure\Context\ReferenceBooks\Row\Dto;

use Application\Context\ReferenceBooks\Row\Dto\GetReferenceBookUpdateDraftRowListDto;
use Application\Shared\Dto\Trackable;
use Domain\Shared\ValueObjects\Id\Id;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class GetReferenceBookUpdateDraftRowListSpatieDto extends DataTransferObject implements GetReferenceBookUpdateDraftRowListDto, Trackable
{
    public string $referenceBookUpdateDraftId;
    public int $page;
    public int $perPage;

    /**
     * @throws Throwable
     */
    public function getReferenceBookUpdateDraftId(): Id
    {
        return new Id($this->referenceBookUpdateDraftId);
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
            'referenceBookId' => $this->getReferenceBookUpdateDraftId()->value(),
        ];
    }
}
