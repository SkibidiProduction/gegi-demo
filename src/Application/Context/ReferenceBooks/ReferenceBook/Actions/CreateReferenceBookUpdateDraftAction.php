<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\CreateReferenceBookUpdateDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookRepository;
use Application\Context\ReferenceBooks\ReferenceBook\Tasks\CreateReferenceBookUpdateDraftTask;
use Application\Context\ReferenceBooks\ReferenceBook\ViewModels\ReferenceBookUpdateDraftPayload;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class CreateReferenceBookUpdateDraftAction
{
    public function __construct(
        private readonly ReferenceBookRepository $repository,
        private readonly EventDispatcher $eventDispatcher,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(CreateReferenceBookUpdateDraftDto $dto): ?ReferenceBookUpdateDraftPayload
    {
        $referenceBook = $this->repository->findById($dto->getId());

        $task = new CreateReferenceBookUpdateDraftTask($this->repository->updateDrafts(), $this->eventDispatcher);

        $referenceBookUpdateDraft = $task->run($referenceBook);

        return new ReferenceBookUpdateDraftPayload($referenceBookUpdateDraft);
    }
}
