<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Proxy;

use Application\Context\ReferenceBooks\Row\Repositories\RowRepository;
use Domain\Context\ReferenceBooks\Row\ValueObjects\Value;
use Domain\Shared\ValueObjects\Id\Id;

interface ValueProxy
{
    public function __construct(Id $columnId, RowRepository $repository);

    /**
     * @return array<Value>
     */
    public function get(): array;
}
