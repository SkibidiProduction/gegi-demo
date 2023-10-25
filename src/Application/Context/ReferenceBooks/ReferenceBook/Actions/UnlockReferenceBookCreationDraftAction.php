<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\UnlockReferenceBookCreationDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Application\Context\ReferenceBooks\ReferenceBook\Tasks\UnlockReferenceBookCreationDraftTask;
use Application\Context\ReferenceBooks\ReferenceBook\ViewModels\ReferenceBookCreationDraftPayload;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class UnlockReferenceBookCreationDraftAction
{
    public function __construct(
        private readonly ReferenceBookCreationDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(UnlockReferenceBookCreationDraftDto $dto): ReferenceBookCreationDraftPayload
    {
        $unlockTask = new UnlockReferenceBookCreationDraftTask(
            $this->repository,
            $this->eventDispatcher
        );

        $referenceBookCreationDraft = $unlockTask->run($dto);

        return new ReferenceBookCreationDraftPayload($referenceBookCreationDraft);
    }
}
