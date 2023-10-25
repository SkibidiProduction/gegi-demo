<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Proxy;

use Application\Context\ReferenceBooks\Column\Repositories\ColumnCreationDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\Proxy\ColumnCreationDraftProxy;
use Domain\Shared\ValueObjects\Id\Id;

class SqlColumnsCreationDraftProxy implements ColumnCreationDraftProxy
{
    public function __construct(
        protected readonly Id $referenceBookId,
        protected readonly ColumnCreationDraftRepository $repository
    ) {
    }

    public function get(): array
    {
        return $this->repository->allByReferenceBookId($this->referenceBookId);
    }
}
