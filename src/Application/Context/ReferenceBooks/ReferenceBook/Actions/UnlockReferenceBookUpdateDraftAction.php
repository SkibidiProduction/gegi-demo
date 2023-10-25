<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\UnlockReferenceBookUpdateDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookUpdateDraftRepository;
use Application\Context\ReferenceBooks\ReferenceBook\Tasks\UnlockReferenceBookUpdateDraftTask;
use Application\Context\ReferenceBooks\ReferenceBook\ViewModels\ReferenceBookUpdateDraftPayload;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class UnlockReferenceBookUpdateDraftAction
{
    public function __construct(
        private readonly ReferenceBookUpdateDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(UnlockReferenceBookUpdateDraftDto $dto): ReferenceBookUpdateDraftPayload
    {
        $unlockTask = new UnlockReferenceBookUpdateDraftTask(
            $this->repository,
            $this->eventDispatcher
        );

        $referenceBookCreationDraft = $unlockTask->run($dto);

        return new ReferenceBookUpdateDraftPayload($referenceBookCreationDraft);
    }
}
