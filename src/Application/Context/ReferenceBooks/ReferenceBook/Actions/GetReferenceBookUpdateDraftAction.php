<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\GetReferenceBookUpdateDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookUpdateDraft;
use Throwable;

final class GetReferenceBookUpdateDraftAction
{
    public function __construct(private readonly ReferenceBookRepository $repository)
    {
    }

    /**
     * @throws Throwable
     */
    public function run(GetReferenceBookUpdateDraftDto $dto): ReferenceBookUpdateDraft
    {
        return $this->repository->updateDrafts()->getById($dto->getId());
    }
}
