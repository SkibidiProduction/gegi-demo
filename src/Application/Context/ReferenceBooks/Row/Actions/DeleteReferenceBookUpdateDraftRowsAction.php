<?php

namespace Application\Context\ReferenceBooks\Row\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookUpdateDraftRepository;
use Application\Context\ReferenceBooks\ReferenceBook\ViewModels\ReferenceBookUpdateDraftPayload;
use Application\Context\ReferenceBooks\Row\Dto\DeleteReferenceBookUpdateDraftRowsDto;
use Application\Context\ReferenceBooks\Row\Tasks\DeleteReferenceBookUpdateRowsTask;
use Domain\Shared\Events\EventDispatcher;

final class DeleteReferenceBookUpdateDraftRowsAction
{
    public function __construct(
        private readonly ReferenceBookUpdateDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    public function run(DeleteReferenceBookUpdateDraftRowsDto $dto): ReferenceBookUpdateDraftPayload
    {
        $deleteRowsTask = new DeleteReferenceBookUpdateRowsTask($this->repository, $this->eventDispatcher);
        $referenceBookUpdateDraft = $deleteRowsTask->run($dto);
        return new ReferenceBookUpdateDraftPayload($referenceBookUpdateDraft);
    }
}
