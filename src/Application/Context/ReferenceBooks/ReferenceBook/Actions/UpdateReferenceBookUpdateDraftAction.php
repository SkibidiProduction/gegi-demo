<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\UpdateReferenceBookUpdateDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookUpdateDraftRepository;
use Application\Context\ReferenceBooks\ReferenceBook\Tasks\UpdateReferenceBookUpdateDraftTask;
use Application\Context\ReferenceBooks\ReferenceBook\ViewModels\ReferenceBookUpdateDraftPayload;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class UpdateReferenceBookUpdateDraftAction
{
    public function __construct(
        private readonly ReferenceBookUpdateDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(UpdateReferenceBookUpdateDraftDto $dto): ReferenceBookUpdateDraftPayload
    {
        $updateTask = new UpdateReferenceBookUpdateDraftTask($this->repository, $this->eventDispatcher);
        $referenceBookUpdateDraft = $updateTask->run($dto);
        return new ReferenceBookUpdateDraftPayload($referenceBookUpdateDraft);
    }
}
