<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Tasks;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\UpdateReferenceBookDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookRepository;
use Application\Shared\Tasks\Transactions\TransactionTask;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBook;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class UpdateReferenceBookTask
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
    public function run(UpdateReferenceBookDto $dto): ReferenceBook
    {
        return $this->transactionTask->run(function () use ($dto) {
            $draft = $this->repository->updateDrafts()->findById($dto->getDraftId());
            $referenceBook = $this->repository->findById($dto->getDraftId());

            $referenceBook->update($draft);

            $this->repository->update($referenceBook);
            $this->repository->updateDrafts()->delete($dto->getDraftId());

            $this->eventDispatcher->dispatch($draft);
            $this->eventDispatcher->dispatch($referenceBook);

            return $referenceBook;
        });
    }
}
