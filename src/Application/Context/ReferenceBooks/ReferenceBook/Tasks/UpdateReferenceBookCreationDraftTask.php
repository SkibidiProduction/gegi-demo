<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Tasks;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\UpdateReferenceBookCreationDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Enums\UpdatableValueTypeEnum;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Description\Description;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class UpdateReferenceBookCreationDraftTask
{
    public function __construct(
        private readonly ReferenceBookCreationDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(UpdateReferenceBookCreationDraftDto $dto): ReferenceBookCreationDraft
    {
        $referenceBookCreationDraft = $this->repository->findById($dto->getId());
        $this->updateField($referenceBookCreationDraft, $dto->getValueType(), $dto->getValue());
        $this->repository->update($referenceBookCreationDraft);
        $this->eventDispatcher->dispatch($referenceBookCreationDraft);
        return $referenceBookCreationDraft;
    }

    /**
     * @throws Throwable
     */
    private function updateField(
        ReferenceBookCreationDraft $referenceBookCreationDraft,
        UpdatableValueTypeEnum $valueType,
        mixed $value
    ): void {
        match ($valueType->value) {
            UpdatableValueTypeEnum::Name->value
                => $referenceBookCreationDraft->updateName(new Name($value)),
            UpdatableValueTypeEnum::Description->value
                => $referenceBookCreationDraft->updateDescription($value ? new Description($value) : null)
        };
    }
}
