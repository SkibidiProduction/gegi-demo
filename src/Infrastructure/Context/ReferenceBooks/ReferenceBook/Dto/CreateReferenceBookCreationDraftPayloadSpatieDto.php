<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Dto;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\CreateReferenceBookCreationDraftPayloadDto;
use Application\Shared\Dto\Trackable;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Shared\ValueObjects\Id\Id;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class CreateReferenceBookCreationDraftPayloadSpatieDto extends DataTransferObject implements CreateReferenceBookCreationDraftPayloadDto, Trackable
{
    public ?Id $recordId;

    public ?ReferenceBookCreationDraft $record;

    public ?array $errors = null;

    //TODO: Поле добавлено для корректного resolve'а полей query: Query!, чтобы не поднимать библиотеку до v6
    public array $query = [];

    public function getRecordId(): ?Id
    {
        return $this->recordId;
    }

    public function getRecord(): ?ReferenceBookCreationDraft
    {
        return $this->record;
    }

    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * @throws Throwable
     */
    public function trackData(): array
    {
        return [
            'recordId' => $this->getRecordId(),
            'record' => $this->getRecord(),
            'errors' => $this->getErrors(),
        ];
    }
}
