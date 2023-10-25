<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\LockReferenceBookCreationDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Application\Context\ReferenceBooks\ReferenceBook\Tasks\LockReferenceBookCreationDraftTask;
use Application\Context\ReferenceBooks\ReferenceBook\ViewModels\ReferenceBookCreationDraftPayload;
use Application\Shared\Tasks\Transactions\TransactionTask;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class LockReferenceBookCreationDraftAction
{
    public function __construct(
        private readonly ReferenceBookCreationDraftRepository $repository,
        protected readonly TransactionTask $transactionTask,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(LockReferenceBookCreationDraftDto $dto): ReferenceBookCreationDraftPayload
    {
        $lockTask = new LockReferenceBookCreationDraftTask(
            $this->repository,
            $this->transactionTask,
            $this->eventDispatcher
        );

        $referenceBookCreationDraft = $lockTask->run($dto);

        return new ReferenceBookCreationDraftPayload($referenceBookCreationDraft);
    }
}
