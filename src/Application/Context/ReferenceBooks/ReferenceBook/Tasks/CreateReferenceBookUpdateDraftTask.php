<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Tasks;

use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookUpdateDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBook;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookUpdateDraft;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class CreateReferenceBookUpdateDraftTask
{
    public function __construct(
        private readonly ReferenceBookUpdateDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(ReferenceBook $referenceBook): ReferenceBookUpdateDraft
    {
        $referenceBookUpdateDraft = new ReferenceBookUpdateDraft($referenceBook);

        $this->repository->insert($referenceBookUpdateDraft);

        $this->eventDispatcher->dispatch($referenceBookUpdateDraft);

        return $referenceBookUpdateDraft;
    }
}
