<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Proxy;

use Application\Context\ReferenceBooks\Row\Repositories\RowRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\Proxy\ValueProxy;
use Domain\Shared\ValueObjects\Id\Id;

class SqlValueProxy implements ValueProxy
{
    public function __construct(
        private readonly Id $columnId,
        private readonly RowRepository $repository
    ) {
    }

    public function get(): array
    {
        return $this->repository->getValuesByColumnId($this->columnId);
    }
}
