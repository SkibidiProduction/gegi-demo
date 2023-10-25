<?php

namespace Application\Context\ReferenceBooks\Column\Actions;

use Application\Context\ReferenceBooks\Column\Dto\AddColumnToReferenceBookCreationDraftDto;
use Application\Context\ReferenceBooks\Column\Tasks\AddColumnToReferenceBookCreationDraftTask;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Application\Context\ReferenceBooks\ReferenceBook\ViewModels\ReferenceBookCreationDraftPayload;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

class AddColumnToReferenceBookCreationDraftAction
{
    public function __construct(
        private readonly ReferenceBookCreationDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(AddColumnToReferenceBookCreationDraftDto $dto): ReferenceBookCreationDraftPayload
    {
        $addColumnTask = new AddColumnToReferenceBookCreationDraftTask($this->repository, $this->eventDispatcher);
        $referenceBookCreationDraft = $addColumnTask->run($dto);

        return new ReferenceBookCreationDraftPayload($referenceBookCreationDraft);
    }
}
