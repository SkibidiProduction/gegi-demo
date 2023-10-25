<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\ViewModels;

use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookUpdateDraft;
use Domain\Shared\ValueObjects\Id\Id;
use Infrastructure\Shared\Problems\Problem;

class ReferenceBookUpdateDraftPayload
{
    private ?Id $recordId = null;

    private ?ReferenceBookUpdateDraft $record = null;

    /**
     * @var array<Problem>|null
     */
    private ?array $errors = null;

    public function __construct(
        ?ReferenceBookUpdateDraft $referenceBookUpdateDraft = null,
    ) {
        if (!is_null($referenceBookUpdateDraft)) {
            $this->recordId = $referenceBookUpdateDraft->id();
            $this->record = $referenceBookUpdateDraft;
        }
    }

    //TODO: Метод добавлен для корректного resolve'а полей query: Query!, чтобы не поднимать библиотеку до v6
    public function query(): array
    {
        return [];
    }

    public function getRecordId(): ?Id
    {
        return $this->recordId;
    }

    public function getRecord(): ?ReferenceBookUpdateDraft
    {
        return $this->record;
    }

    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * @param array<Problem> $problems
     * @return self
     */
    public function setErrors(array $problems): self
    {
        foreach ($problems as $problem) {
            $this->setError($problem);
        }

        return $this;
    }

    public function setError(Problem $problem): self
    {
        if (is_null($this->errors)) {
            $this->errors = [$problem];
        } else {
            $this->errors[] = $problem;
        }

        return $this;
    }
}
