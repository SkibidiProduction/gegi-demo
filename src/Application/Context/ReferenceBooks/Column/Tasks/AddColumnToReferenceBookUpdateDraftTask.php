<?php

namespace Application\Context\ReferenceBooks\Column\Tasks;

use Application\Context\ReferenceBooks\Column\Dto\AddColumnToReferenceBookUpdateDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookUpdateDraftRepository;
use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookUpdateDraft;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class AddColumnToReferenceBookUpdateDraftTask
{
    public function __construct(
        private readonly ReferenceBookUpdateDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(AddColumnToReferenceBookUpdateDraftDto $dto): ReferenceBookUpdateDraft
    {
        $referenceBookUpdateDraft = $this->repository->findById($dto->getReferenceBookId());

        $column = new Column(
            name: $dto->getName(),
            dataType: $dto->getDataType(),
            width: $dto->getWidth(),
            settings: $dto->getColumnSettings(),
            isRequired: $dto->getIsRequired()
        );

        $referenceBookUpdateDraft->addColumn($column);
        $this->repository->update($referenceBookUpdateDraft);
        $this->eventDispatcher->dispatch($referenceBookUpdateDraft);

        return $referenceBookUpdateDraft;
    }
}
