<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\GetReferenceBookDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBook;

final class GetReferenceBookAction
{
    public function __construct(private readonly ReferenceBookRepository $repository)
    {
    }

    public function run(GetReferenceBookDto $dto): ReferenceBook
    {
        return $this->repository->getById($dto->getId());
    }
}
