<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Dto;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\UpdateReferenceBookUpdateDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Enums\UpdatableValueTypeEnum;
use Application\Shared\Dto\Trackable;
use Domain\Shared\ValueObjects\Id\Id;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class UpdateReferenceBookUpdateDraftSpatieDto extends DataTransferObject implements UpdateReferenceBookUpdateDraftDto, Trackable
{
    public Id|string $id;
    public UpdatableValueTypeEnum|string $type;
    public mixed $value;

    public function trackData(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'value' => $this->value,
        ];
    }

    /**
     * @throws Throwable
     */
    public function getId(): Id
    {
        if (is_string($this->id)) {
            $this->id = new Id($this->id);
        }

        return $this->id;
    }

    public function getValueType(): UpdatableValueTypeEnum
    {
        if (is_string($this->type)) {
            $this->type = UpdatableValueTypeEnum::from($this->type);
        }

        return $this->type;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}
