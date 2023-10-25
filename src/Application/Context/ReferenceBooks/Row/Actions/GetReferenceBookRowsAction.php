<?php

namespace Application\Context\ReferenceBooks\Row\Actions;

use Application\Context\ReferenceBooks\Row\Dto\GetReferenceBookRowListDto;
use Application\Context\ReferenceBooks\Row\Repositories\RowRepository;
use Application\Shared\Utilities\Paginator\Paginator;

final class GetReferenceBookRowsAction
{
    public function __construct(private readonly RowRepository $repository)
    {
    }

    public function run(GetReferenceBookRowListDto $dto): Paginator
    {
        return $this->repository->getPaginated($dto->getPage(), $dto->getPerPage(), $dto->getReferenceBookId());
    }
}
