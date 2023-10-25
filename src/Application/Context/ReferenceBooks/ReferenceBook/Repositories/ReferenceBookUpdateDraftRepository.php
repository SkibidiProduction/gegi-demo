<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Repositories;

use Application\Context\ReferenceBooks\Column\Repositories\ColumnUpdateDraftRepository;
use Application\Context\ReferenceBooks\Row\Repositories\RowUpdateDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookUpdateDraft;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;
use Domain\Shared\ValueObjects\Id\Id;

interface ReferenceBookUpdateDraftRepository
{
    public function getById(Id $id): ?ReferenceBookUpdateDraft;
    public function getByName(Name $name): ?ReferenceBookUpdateDraft;
    public function findById(Id $id): ReferenceBookUpdateDraft;
    public function insert(ReferenceBookUpdateDraft $referenceBook): void;
    public function update(ReferenceBookUpdateDraft $referenceBook): void;
    public function delete(Id $id): void;
    public function columns(): ColumnUpdateDraftRepository;
    public function rows(): RowUpdateDraftRepository;
}
