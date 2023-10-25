<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Proxy;

use Application\Context\ReferenceBooks\Row\Repositories\RowCreationDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\Proxy\RowCreationDraftProxy;
use Domain\Context\ReferenceBooks\Row\Row;
use Domain\Shared\ValueObjects\Id\Id;

class SqlRowsCreationDraftProxy implements RowCreationDraftProxy
{
    public function __construct(
        protected readonly Id $referenceBookId,
        protected readonly RowCreationDraftRepository $repository,
    ) {
    }

    /**
     * @return array<Row>
     */
    public function get(): array
    {
        return $this->repository->getAllByReferenceBookId($this->referenceBookId);
    }
}
