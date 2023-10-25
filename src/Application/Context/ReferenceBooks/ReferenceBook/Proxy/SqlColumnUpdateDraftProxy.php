<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Proxy;

use Application\Context\ReferenceBooks\Column\Repositories\ColumnUpdateDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\Proxy\ColumnUpdateDraftProxy;
use Domain\Shared\ValueObjects\Id\Id;

class SqlColumnUpdateDraftProxy implements ColumnUpdateDraftProxy
{
    public function __construct(
        protected readonly Id $referenceBookId,
        protected readonly ColumnUpdateDraftRepository $repository
    ) {
    }

    public function get(): array
    {
        return $this->repository->allByReferenceBookId($this->referenceBookId);
    }
}
