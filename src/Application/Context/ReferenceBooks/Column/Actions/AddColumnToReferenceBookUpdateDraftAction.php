<?php

namespace Application\Context\ReferenceBooks\Column\Actions;

use Application\Context\ReferenceBooks\Column\Dto\AddColumnToReferenceBookUpdateDraftDto;
use Application\Context\ReferenceBooks\Column\Tasks\AddColumnToReferenceBookUpdateDraftTask;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookUpdateDraftRepository;
use Application\Context\ReferenceBooks\ReferenceBook\ViewModels\ReferenceBookUpdateDraftPayload;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

class AddColumnToReferenceBookUpdateDraftAction
{
    public function __construct(
        private readonly ReferenceBookUpdateDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(AddColumnToReferenceBookUpdateDraftDto $dto): ReferenceBookUpdateDraftPayload
    {
        $addColumnTask = new AddColumnToReferenceBookUpdateDraftTask($this->repository, $this->eventDispatcher);
        $referenceBookCreationDraft = $addColumnTask->run($dto);

        return new ReferenceBookUpdateDraftPayload($referenceBookCreationDraft);
    }
}
