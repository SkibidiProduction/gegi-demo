<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\UpdateReferenceBookDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookRepository;
use Application\Context\ReferenceBooks\ReferenceBook\Tasks\UpdateReferenceBookTask;
use Application\Context\ReferenceBooks\ReferenceBook\ViewModels\ReferenceBookPayload;
use Application\Shared\Tasks\Transactions\TransactionTask;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class UpdateReferenceBookAction
{
    public function __construct(
        private readonly ReferenceBookRepository $repository,
        private readonly TransactionTask $transactionTask,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(UpdateReferenceBookDto $dto): ReferenceBookPayload
    {
        $updateTask = new UpdateReferenceBookTask(
            $this->repository,
            $this->transactionTask,
            $this->eventDispatcher
        );
        $referenceBook = $updateTask->run($dto);

        return new ReferenceBookPayload($referenceBook);
    }
}
