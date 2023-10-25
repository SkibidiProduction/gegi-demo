<?php

namespace Application\Context\ReferenceBooks\Row\Actions;

use Application\Context\ReferenceBooks\Row\Dto\GetReferenceBookUpdateDraftRowListDto;
use Application\Shared\Utilities\Paginator\Paginator;
use Infrastructure\Context\ReferenceBooks\Row\Repositories\RowUpdateDraftSqlRepository;
use ReflectionException;
use Throwable;

final class GetReferenceBookUpdateDraftRowsAction
{
    public function __construct(private readonly RowUpdateDraftSqlRepository $repository)
    {
    }

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    public function run(GetReferenceBookUpdateDraftRowListDto $dto): Paginator
    {
        return $this->repository->getPaginated(
            $dto->getPage(),
            $dto->getPerPage(),
            $dto->getReferenceBookUpdateDraftId()
        );
    }
}
