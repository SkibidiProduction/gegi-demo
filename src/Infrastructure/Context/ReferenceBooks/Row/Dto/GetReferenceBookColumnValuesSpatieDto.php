<?php

namespace Infrastructure\Context\ReferenceBooks\Row\Dto;

use Application\Context\ReferenceBooks\Row\Dto\GetReferenceBookColumnValuesDto;
use Application\Shared\Dto\Trackable;
use Domain\Shared\ValueObjects\Id\Id;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class GetReferenceBookColumnValuesSpatieDto extends DataTransferObject implements GetReferenceBookColumnValuesDto, Trackable
{
    public string|Id $columnId;

    /**
     * @throws Throwable
     */
    public function getId(): Id
    {
        if (!($this->columnId instanceof Id)) {
            $this->columnId = new Id($this->columnId);
        }
        return $this->columnId;
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
