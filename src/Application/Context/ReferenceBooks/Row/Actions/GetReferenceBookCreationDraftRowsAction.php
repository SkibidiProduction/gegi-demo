<?php

namespace Application\Context\ReferenceBooks\Row\Actions;

use Application\Context\ReferenceBooks\Row\Dto\GetReferenceBookCreationDraftRowListDto;
use Application\Shared\Utilities\Paginator\Paginator;
use Infrastructure\Context\ReferenceBooks\Row\Repositories\RowCreationDraftSqlRepository;
use ReflectionException;
use Throwable;

final class GetReferenceBookCreationDraftRowsAction
{
    public function __construct(private readonly RowCreationDraftSqlRepository $repository)
    {
    }

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    public function run(GetReferenceBookCreationDraftRowListDto $dto): Paginator
    {
        return $this->repository->getPaginated(
            $dto->getPage(),
            $dto->getPerPage(),
            $dto->getReferenceBookCreationDraftId()
        );
    }
}
