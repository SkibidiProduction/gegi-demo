<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\CreateReferenceBookDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookRepository;
use Application\Context\ReferenceBooks\ReferenceBook\Tasks\CreateReferenceBookTask;
use Application\Context\ReferenceBooks\ReferenceBook\ViewModels\ReferenceBookPayload;
use Application\Shared\Tasks\Transactions\TransactionTask;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class CreateReferenceBookAction
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
    public function run(CreateReferenceBookDto $dto): ReferenceBookPayload
    {
        $creationTask = new CreateReferenceBookTask(
            $this->repository,
            $this->transactionTask,
            $this->eventDispatcher
        );

        $referenceBook = $creationTask->run($dto);

        return new ReferenceBookPayload($referenceBook);
    }
}
