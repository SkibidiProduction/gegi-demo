<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Tasks;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\UpdateReferenceBookUpdateDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Enums\UpdatableValueTypeEnum;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookUpdateDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookUpdateDraft;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Description\Description;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class UpdateReferenceBookUpdateDraftTask
{
    public function __construct(
        private readonly ReferenceBookUpdateDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(UpdateReferenceBookUpdateDraftDto $dto): ReferenceBookUpdateDraft
    {
        $referenceBookUpdateDraft = $this->repository->findById($dto->getId());
        $this->updateField($referenceBookUpdateDraft, $dto->getValueType(), $dto->getValue());
        $this->repository->update($referenceBookUpdateDraft);
        $this->eventDispatcher->dispatch($referenceBookUpdateDraft);
        return $referenceBookUpdateDraft;
    }

    /**
     * @throws Throwable
     */
    private function updateField(
        ReferenceBookUpdateDraft $referenceBookCreationDraft,
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
