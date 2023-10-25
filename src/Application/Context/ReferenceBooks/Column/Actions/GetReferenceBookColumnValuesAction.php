<?php

namespace Application\Context\ReferenceBooks\Column\Actions;

use Application\Context\ReferenceBooks\Row\Dto\GetReferenceBookColumnValuesDto;
use Application\Context\ReferenceBooks\Row\Repositories\RowRepository;

class GetReferenceBookColumnValuesAction
{
    public function __construct(protected readonly RowRepository $repository)
    {
    }

    public function run(GetReferenceBookColumnValuesDto $dto): array
    {
        return $this->repository->getValuesByColumnId($dto->getId());
    }
}
