<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Tasks;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\LockReferenceBookUpdateDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookUpdateDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookUpdateDraft;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

class LockReferenceBookUpdateDraftTask
{
    public function __construct(
        private readonly ReferenceBookUpdateDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(LockReferenceBookUpdateDraftDto $dto): ReferenceBookUpdateDraft
    {
        $referenceBookUpdateDraft = $this->repository->findById($dto->getReferenceBookUpdateDraftId());
        $referenceBookUpdateDraft->lockBy($dto->getUserId());
        $this->repository->update($referenceBookUpdateDraft);
        $this->eventDispatcher->dispatch($referenceBookUpdateDraft);
        return $referenceBookUpdateDraft;
    }
}
