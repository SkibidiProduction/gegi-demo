<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\GetReferenceBookCreationDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;

final class GetReferenceBookCreationDraftAction
{
    public function __construct(private readonly ReferenceBookCreationDraftRepository $repository)
    {
    }

    public function run(GetReferenceBookCreationDraftDto $dto): ReferenceBookCreationDraft
    {
        return $this->repository->getById($dto->getId());
    }
}
