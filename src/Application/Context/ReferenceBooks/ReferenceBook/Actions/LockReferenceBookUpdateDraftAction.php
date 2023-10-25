<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\LockReferenceBookUpdateDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookUpdateDraftRepository;
use Application\Context\ReferenceBooks\ReferenceBook\Tasks\LockReferenceBookUpdateDraftTask;
use Application\Context\ReferenceBooks\ReferenceBook\ViewModels\ReferenceBookUpdateDraftPayload;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class LockReferenceBookUpdateDraftAction
{
    public function __construct(
        private readonly ReferenceBookUpdateDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(LockReferenceBookUpdateDraftDto $dto): ReferenceBookUpdateDraftPayload
    {
        $lockTask = new LockReferenceBookUpdateDraftTask(
            $this->repository,
            $this->eventDispatcher
        );

        $referenceBookUpdateDraft = $lockTask->run($dto);

        return new ReferenceBookUpdateDraftPayload($referenceBookUpdateDraft);
    }
}
