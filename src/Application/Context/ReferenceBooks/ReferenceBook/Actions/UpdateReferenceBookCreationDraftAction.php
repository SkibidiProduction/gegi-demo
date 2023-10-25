<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\UpdateReferenceBookCreationDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Application\Context\ReferenceBooks\ReferenceBook\Tasks\UpdateReferenceBookCreationDraftTask;
use Application\Context\ReferenceBooks\ReferenceBook\ViewModels\ReferenceBookCreationDraftPayload;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class UpdateReferenceBookCreationDraftAction
{
    public function __construct(
        private readonly ReferenceBookCreationDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(UpdateReferenceBookCreationDraftDto $dto): ReferenceBookCreationDraftPayload
    {
        $updateCreationDraftTask = new UpdateReferenceBookCreationDraftTask($this->repository, $this->eventDispatcher);
        $referenceBookCreationDraft = $updateCreationDraftTask->run($dto);
        return new ReferenceBookCreationDraftPayload($referenceBookCreationDraft);
    }
}
