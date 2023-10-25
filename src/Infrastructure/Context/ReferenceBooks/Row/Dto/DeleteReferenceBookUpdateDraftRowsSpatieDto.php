<?php

namespace Infrastructure\Context\ReferenceBooks\Row\Dto;

use Application\Context\ReferenceBooks\Row\Dto\DeleteReferenceBookUpdateDraftRowsDto;
use Application\Shared\Dto\Trackable;
use Domain\Shared\ValueObjects\Id\Id;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class DeleteReferenceBookUpdateDraftRowsSpatieDto extends DataTransferObject implements DeleteReferenceBookUpdateDraftRowsDto, Trackable
{
    public Id|string $id;
    public array $rowIds;

    /**
     * @return Id
     * @throws Throwable
     */
    public function getReferenceBookUpdateDraftId(): Id
    {
        if (is_string($this->id)) {
            $this->id = new Id($this->id);
        }

        return $this->id;
    }

    /**
     * @return array<Id>
     * @throws Throwable
     */
    public function getRowIds(): array
    {
        if (isset($this->rowIds[0]) && !($this->rowIds[0] instanceof Id)) {
            foreach ($this->rowIds as $i => $iValue) {
                $this->rowIds[$i] = new Id($iValue);
            }
        }

        return $this->rowIds;
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function trackData(): array
    {
        return [
            'referenceBookId' => $this->getReferenceBookUpdateDraftId()->value(),
        ];
    }
}
