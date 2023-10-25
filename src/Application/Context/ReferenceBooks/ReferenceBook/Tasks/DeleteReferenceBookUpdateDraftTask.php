<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Tasks;

use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookUpdateDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookUpdateDraft;
use Domain\Shared\Events\EventDispatcher;
use Domain\Shared\ValueObjects\Id\Id;
use Throwable;

final class DeleteReferenceBookUpdateDraftTask
{
    public function __construct(
        private readonly ReferenceBookUpdateDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(Id $referenceBookUpdateDraftId): ReferenceBookUpdateDraft
    {
        $referenceBookUpdateDraft = $this->repository->findById($referenceBookUpdateDraftId);
        $this->repository->delete($referenceBookUpdateDraftId);
        $this->eventDispatcher->dispatch($referenceBookUpdateDraft);

        return $referenceBookUpdateDraft;
    }
}
