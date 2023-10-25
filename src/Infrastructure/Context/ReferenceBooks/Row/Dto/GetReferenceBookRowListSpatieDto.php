<?php

namespace Infrastructure\Context\ReferenceBooks\Row\Dto;

use Application\Context\ReferenceBooks\Row\Dto\GetReferenceBookRowListDto;
use Application\Shared\Dto\Trackable;
use Domain\Shared\ValueObjects\Id\Id;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class GetReferenceBookRowListSpatieDto extends DataTransferObject implements GetReferenceBookRowListDto, Trackable
{
    public string $referenceBookId;
    public int $page;
    public int $perPage;

    /**
     * @throws Throwable
     */
    public function getReferenceBookId(): Id
    {
        return new Id($this->referenceBookId);
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
            'referenceBookId' => $this->getReferenceBookId()->value(),
        ];
    }
}
