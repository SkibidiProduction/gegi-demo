<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\DeleteReferenceBookUpdateDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookUpdateDraftRepository;
use Application\Context\ReferenceBooks\ReferenceBook\Tasks\DeleteReferenceBookUpdateDraftTask;
use Application\Context\ReferenceBooks\ReferenceBook\ViewModels\ReferenceBookUpdateDraftPayload;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class DeleteReferenceBookUpdateDraftAction
{
    public function __construct(
        private readonly ReferenceBookUpdateDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(DeleteReferenceBookUpdateDraftDto $dto): ?ReferenceBookUpdateDraftPayload
    {
        $task = new DeleteReferenceBookUpdateDraftTask($this->repository, $this->eventDispatcher);
        $referenceBookUpdateDraft = $task->run($dto->getId());

        return new ReferenceBookUpdateDraftPayload($referenceBookUpdateDraft);
    }
}
