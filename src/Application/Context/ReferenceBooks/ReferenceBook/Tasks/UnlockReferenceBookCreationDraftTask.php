<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Tasks;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\UnlockReferenceBookCreationDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

class UnlockReferenceBookCreationDraftTask
{
    public function __construct(
        private readonly ReferenceBookCreationDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(UnlockReferenceBookCreationDraftDto $dto): ReferenceBookCreationDraft
    {
        $referenceBookCreationDraft = $this->repository->findById($dto->getReferenceBookCreationDraftId());
        $referenceBookCreationDraft->unlock();
        $this->repository->update($referenceBookCreationDraft);
        $this->eventDispatcher->dispatch($referenceBookCreationDraft);
        return $referenceBookCreationDraft;
    }
}
