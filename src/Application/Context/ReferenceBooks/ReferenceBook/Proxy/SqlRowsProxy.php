<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Proxy;

use Application\Context\ReferenceBooks\Row\Repositories\RowRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\Proxy\RowProxy;
use Domain\Shared\ValueObjects\Id\Id;

class SqlRowsProxy implements RowProxy
{
    public function __construct(
        protected readonly Id $referenceBookId,
        protected readonly RowRepository $repository
    ) {
    }

    public function get(): array
    {
        return $this->repository->getAllByReferenceBookId($this->referenceBookId);
    }
}
