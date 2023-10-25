<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\GetReferenceBookListDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\Filters\ReferenceBookFilter;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookRepository;
use Application\Shared\Criteria\Criteria;
use Application\Shared\Utilities\Paginator\Paginator;

final class GetReferenceBookListAction
{
    private array $availableFilters = [
        'name' => 'whereNameLike',
        'description' => 'whereDescriptionLike',
        'status' => 'whereStatus',
        'createdAtFrom' => 'whereCreatedAtFrom',
        'createdAtTo' => 'whereCreatedAtTo',
        'updatedAtFrom' => 'whereUpdatedAtFrom',
        'updatedAtTo' => 'whereUpdatedAtTo',
    ];

    public function __construct(
        private readonly ReferenceBookRepository $repository,
        private readonly ReferenceBookFilter $filter
    ) {
    }

    public function run(GetReferenceBookListDto $dto): Paginator
    {
        $filters = $this->setFilters($dto, $this->filter);
        return $this->repository->match($filters)->getPaginated($dto->getPage(), $dto->getPerPage());
    }

    private function setFilters(GetReferenceBookListDto $dto, ReferenceBookFilter $filter): Criteria
    {
        return (new Criteria())
            ->add($filter->orderBy($dto->getOrderBy(), $dto->getOrderDirection()))
            ->addByConditions($dto->filters(), $filter, $this->availableFilters);
    }
}
