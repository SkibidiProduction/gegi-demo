<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Tasks;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\UnlockReferenceBookUpdateDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookUpdateDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookUpdateDraft;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

class UnlockReferenceBookUpdateDraftTask
{
    public function __construct(
        private readonly ReferenceBookUpdateDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(UnlockReferenceBookUpdateDraftDto $dto): ReferenceBookUpdateDraft
    {
        $referenceBookUpdateDraft = $this->repository->findById($dto->getReferenceBookUpdateDraftId());

        $referenceBookUpdateDraft->unlock();
        $this->repository->update($referenceBookUpdateDraft);
        $this->eventDispatcher->dispatch($referenceBookUpdateDraft);

        return $referenceBookUpdateDraft;
    }
}
