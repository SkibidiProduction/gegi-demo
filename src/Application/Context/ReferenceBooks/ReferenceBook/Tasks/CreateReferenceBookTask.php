<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Tasks;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\CreateReferenceBookDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookRepository;
use Application\Shared\Tasks\Transactions\TransactionTask;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBook;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class CreateReferenceBookTask
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
    public function run(CreateReferenceBookDto $dto): ReferenceBook
    {
        return $this->transactionTask->run(function () use ($dto) {
            $referenceBookCreationDraft = $this->repository->creationDrafts()->findById($dto->getDraftId());
            $referenceBook = new ReferenceBook($referenceBookCreationDraft);

            $this->repository->insert($referenceBook);
            $this->repository->creationDrafts()->delete($referenceBookCreationDraft->id());

            $this->eventDispatcher->dispatch($referenceBookCreationDraft);
            $this->eventDispatcher->dispatch($referenceBook);

            return $referenceBook;
        });
    }
}
