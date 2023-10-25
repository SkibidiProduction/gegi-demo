<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Tasks;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\LockReferenceBookCreationDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Application\Shared\Tasks\Transactions\TransactionTask;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

class LockReferenceBookCreationDraftTask
{
    public function __construct(
        private readonly ReferenceBookCreationDraftRepository $repository,
        private readonly TransactionTask $transactionTask,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(LockReferenceBookCreationDraftDto $dto): ReferenceBookCreationDraft
    {
        return $this->transactionTask->run(function () use ($dto) {
            $referenceBookCreationDraft = $this->repository->findById($dto->getReferenceBookCreationDraftId());
            $referenceBookCreationDraft->lockBy($dto->getUserId());
            $this->repository->update($referenceBookCreationDraft);
            $this->eventDispatcher->dispatch($referenceBookCreationDraft);
            return $referenceBookCreationDraft;
        });
    }
}
