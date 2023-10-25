<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Tasks;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\CreateReferenceBookCreationDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

final class CreateReferenceBookCreationDraftTask
{
    public function __construct(
        private readonly ReferenceBookCreationDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(CreateReferenceBookCreationDraftDto $dto): ReferenceBookCreationDraft
    {
        $referenceBookCreationDraft = new ReferenceBookCreationDraft(
            name: $dto->getName(),
            code: $dto->getCode(),
            userId: $dto->getUserId(),
        );

        $referenceBookCreationDraft->lockBy($dto->getUserId());

        $this->repository->insert($referenceBookCreationDraft);
        $this->eventDispatcher->dispatch($referenceBookCreationDraft);

        return $referenceBookCreationDraft;
    }
}
