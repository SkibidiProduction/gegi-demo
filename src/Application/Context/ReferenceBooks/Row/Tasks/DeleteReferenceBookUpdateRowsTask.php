<?php

namespace Application\Context\ReferenceBooks\Row\Tasks;

use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookUpdateDraftRepository;
use Application\Context\ReferenceBooks\Row\Dto\DeleteReferenceBookUpdateDraftRowsDto;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookUpdateDraft;
use Domain\Shared\Events\EventDispatcher;

class DeleteReferenceBookUpdateRowsTask
{
    public function __construct(
        private readonly ReferenceBookUpdateDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    public function run(DeleteReferenceBookUpdateDraftRowsDto $dto): ReferenceBookUpdateDraft
    {
        $referenceBookUpdateDraft = $this->repository->findById($dto->getReferenceBookUpdateDraftId());

        foreach ($dto->getRowIds() as $rowId) {
            $referenceBookUpdateDraft->deleteRow($rowId);
        }

        $this->repository->update($referenceBookUpdateDraft);
        $this->eventDispatcher->dispatch($referenceBookUpdateDraft);

        return $referenceBookUpdateDraft;
    }
}
