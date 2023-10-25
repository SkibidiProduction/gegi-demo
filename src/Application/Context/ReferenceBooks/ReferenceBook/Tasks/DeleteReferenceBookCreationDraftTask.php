<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Tasks;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\DeleteReferenceBookCreationDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class DeleteReferenceBookCreationDraftTask
{
    public function __construct(
        private readonly ReferenceBookCreationDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(DeleteReferenceBookCreationDraftDto $dto): ReferenceBookCreationDraft
    {
        $referenceBookCreationDraft = $this->repository->findById($dto->getId());
        $referenceBookCreationDraft->update();
        $this->repository->delete($referenceBookCreationDraft->id());
        $this->eventDispatcher->dispatch($referenceBookCreationDraft);

        return $referenceBookCreationDraft;
    }
}
