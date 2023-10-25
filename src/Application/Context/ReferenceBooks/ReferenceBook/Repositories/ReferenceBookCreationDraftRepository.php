<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Repositories;

use Application\Context\ReferenceBooks\Column\Repositories\ColumnCreationDraftRepository;
use Application\Context\ReferenceBooks\Row\Repositories\RowCreationDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;
use Domain\Shared\ValueObjects\Id\Id;

interface ReferenceBookCreationDraftRepository
{
    public function getById(Id $id): ?ReferenceBookCreationDraft;
    public function getByName(Name $name): ?ReferenceBookCreationDraft;
    public function findById(Id $id): ReferenceBookCreationDraft;
    public function insert(ReferenceBookCreationDraft $referenceBook): void;
    public function update(ReferenceBookCreationDraft $referenceBook): void;
    public function delete(Id $id): void;
    public function columns(): ColumnCreationDraftRepository;
    public function rows(): RowCreationDraftRepository;
}
