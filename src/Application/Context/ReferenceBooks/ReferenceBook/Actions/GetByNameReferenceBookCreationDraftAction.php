<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\GetByNameReferenceBookCreationDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;

final class GetByNameReferenceBookCreationDraftAction
{
    public function __construct(private readonly ReferenceBookCreationDraftRepository $repository)
    {
    }

    public function run(GetByNameReferenceBookCreationDraftDto $dto): ?ReferenceBookCreationDraft
    {
        return $this->repository->getByName($dto->getName());
    }
}
