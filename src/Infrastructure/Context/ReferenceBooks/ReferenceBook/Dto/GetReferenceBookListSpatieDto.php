<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Dto;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\GetReferenceBookListDto;
use Application\Context\ReferenceBooks\ReferenceBook\Dto\GetReferenceBookListFiltersDto;
use Application\Shared\Dto\Trackable;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\DataTransferObject;

class GetReferenceBookListSpatieDto extends DataTransferObject implements GetReferenceBookListDto, Trackable
{
    public int $page = 1;
    public int $perPage = 25;
    public string $orderBy = 'name';
    public string $orderDirection = 'asc';
    public GetReferenceBookListFiltersDto $filters;

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getOrderBy(): string
    {
        return Str::snake($this->orderBy);
    }

    public function getOrderDirection(): string
    {
        return $this->orderDirection;
    }

    public function filters(): GetReferenceBookListFiltersDto
    {
        return $this->filters;
    }

    public function trackData(): array
    {
        return [
            'page' => $this->getPage(),
            'perPage' => $this->getPerPage(),
            'orderBy' => $this->getOrderBy(),
            'orderDirection' => $this->getOrderDirection(),
            'filters.name' => $this->filters()->getName(),
            'filters.description' => $this->filters()->getDescription(),
            'filters.status' => $this->filters()->getStatus(),
            'filters.createdAtFrom' => $this->filters()->getCreatedAtRange()->from(),
            'filters.createdAtTo' => $this->filters()->getCreatedAtRange()->to(),
            'filters.updatedAtFrom' => $this->filters()->getUpdatedAtRange()->from(),
            'filters.updatedAtTo' => $this->filters()->getUpdatedAtRange()->to(),
        ];
    }
}
