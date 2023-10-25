<?php

namespace Application\Context\ReferenceBooks\Column\Tasks;

use Application\Context\ReferenceBooks\Column\Dto\AddColumnToReferenceBookCreationDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class AddColumnToReferenceBookCreationDraftTask
{
    public function __construct(
        private readonly ReferenceBookCreationDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(AddColumnToReferenceBookCreationDraftDto $dto): ReferenceBookCreationDraft
    {
        $referenceBookCreationDraft = $this->repository->findById($dto->getReferenceBookId());

        $column = new Column(
            name: $dto->getName(),
            dataType: $dto->getDataType(),
            width: $dto->getWidth(),
            settings: $dto->getColumnSettings(),
            isRequired: $dto->getIsRequired()
        );

        $referenceBookCreationDraft->addColumn($column);
        $this->repository->update($referenceBookCreationDraft);
        $this->eventDispatcher->dispatch($referenceBookCreationDraft);

        return $referenceBookCreationDraft;
    }
}
