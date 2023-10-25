<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Proxy;

use Application\Context\ReferenceBooks\Row\Repositories\RowUpdateDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\Proxy\RowUpdateDraftProxy;
use Domain\Context\ReferenceBooks\Row\Row;
use Domain\Shared\ValueObjects\Id\Id;

class SqlRowUpdateDraftProxy implements RowUpdateDraftProxy
{
    public function __construct(
        protected readonly Id $referenceBookId,
        protected readonly RowUpdateDraftRepository $repository,
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
