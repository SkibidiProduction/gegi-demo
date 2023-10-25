<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Tasks;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\UpdateStatusReferenceBookUpdateDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookUpdateDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookUpdateDraft;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class UpdateStatusReferenceBookUpdateDraftTask
{
    public function __construct(
        private readonly ReferenceBookUpdateDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(UpdateStatusReferenceBookUpdateDraftDto $dto): ReferenceBookUpdateDraft
    {
        $referenceBookUpdateDraft = $this->repository->findById($dto->getId());

        if ($referenceBookUpdateDraft->status()->value() != $dto->getNewStatus()->value()) {
            $referenceBookUpdateDraft->updateStatus($dto->getNewStatus());
            $this->repository->update($referenceBookUpdateDraft);
            $this->eventDispatcher->dispatch($referenceBookUpdateDraft);
        }

        return $referenceBookUpdateDraft;
    }
}
