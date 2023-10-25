<?php

namespace Infrastructure\Context\ReferenceBooks\Row\Dto;

use Application\Context\ReferenceBooks\Column\Dto\AddRowToReferenceBookCreationDraftDto;
use Application\Shared\Dto\Trackable;
use Domain\Context\ReferenceBooks\Row\ValueObjects\Value;
use Domain\Shared\ValueObjects\Id\Id;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class AddRowToReferenceBookCreationDraftSpatieDto extends DataTransferObject implements AddRowToReferenceBookCreationDraftDto, Trackable
{
    public Id|string $id;
    public array $values;

    /**
     * @return Id
     * @throws Throwable
     */
    public function getReferenceBookCreationDraftId(): Id
    {
        if (is_string($this->id)) {
            $this->id = new Id($this->id);
        }

        return $this->id;
    }

    /**
     * @return array|Value[]
     * @throws Throwable
     */
    public function getValues(): array
    {
        if (isset($this->values[0]) && !($this->values[0] instanceof Value)) {
            foreach ($this->values as $i => $iValue) {
                $this->values[$i] = new Value($iValue['value'], new Id($iValue['columnId']));
            }
        }

        return $this->values;
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function trackData(): array
    {
        return [
            'referenceBookId' => $this->getReferenceBookCreationDraftId()->value(),
        ];
    }
}
