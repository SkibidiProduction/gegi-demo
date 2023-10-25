<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Proxy;

use Application\Context\ReferenceBooks\Column\Repositories\ColumnRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\Proxy\ColumnProxy;
use Domain\Shared\ValueObjects\Id\Id;

class SqlColumnsProxy implements ColumnProxy
{
    public function __construct(
        protected readonly Id $referenceBookId,
        protected readonly ColumnRepository $repository
    ) {
    }

    public function get(): array
    {
        return $this->repository->allByReferenceBookId($this->referenceBookId);
    }
}
