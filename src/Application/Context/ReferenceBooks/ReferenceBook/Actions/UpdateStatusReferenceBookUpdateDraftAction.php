<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\UpdateStatusReferenceBookUpdateDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookUpdateDraftRepository;
use Application\Context\ReferenceBooks\ReferenceBook\Tasks\UpdateStatusReferenceBookUpdateDraftTask;
use Application\Context\ReferenceBooks\ReferenceBook\ViewModels\ReferenceBookUpdateDraftPayload;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class UpdateStatusReferenceBookUpdateDraftAction
{
    public function __construct(
        private readonly ReferenceBookUpdateDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(UpdateStatusReferenceBookUpdateDraftDto $dto): ?ReferenceBookUpdateDraftPayload
    {
        $task = new UpdateStatusReferenceBookUpdateDraftTask($this->repository, $this->eventDispatcher);
        $referenceBookUpdateDraft = $task->run($dto);

        return new ReferenceBookUpdateDraftPayload($referenceBookUpdateDraft);
    }
}
