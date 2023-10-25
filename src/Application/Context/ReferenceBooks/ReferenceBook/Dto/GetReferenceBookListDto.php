<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

interface GetReferenceBookListDto
{
    public function getPage(): int;

    public function getPerPage(): int;

    public function getOrderBy(): string;

    public function getOrderDirection(): string;

    public function filters(): GetReferenceBookListFiltersDto;
}
