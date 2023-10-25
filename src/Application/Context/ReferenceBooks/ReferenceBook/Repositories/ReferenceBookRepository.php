<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Repositories;

use Application\Context\ReferenceBooks\Column\Repositories\ColumnRepository;
use Application\Context\ReferenceBooks\Row\Repositories\RowRepository;
use Application\Shared\Criteria\Criteria;
use Application\Shared\Utilities\Paginator\Paginator;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBook;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;
use Domain\Shared\ValueObjects\Id\Id;

interface ReferenceBookRepository
{
    public function getById(Id $id): ?ReferenceBook;
    public function getByName(Name $name): ?ReferenceBook;
    public function findById(Id $id): ReferenceBook;
    public function getPaginated(int $page, int $limit): Paginator;
    public function update(ReferenceBook $referenceBook): void;
    public function match(Criteria $criteria): ReferenceBookRepository;
    public function columns(): ColumnRepository;
    public function rows(): RowRepository;
    public function creationDrafts(): ReferenceBookCreationDraftRepository;
    public function updateDrafts(): ReferenceBookUpdateDraftRepository;
    public function insert(ReferenceBook $referenceBook): void;
}
