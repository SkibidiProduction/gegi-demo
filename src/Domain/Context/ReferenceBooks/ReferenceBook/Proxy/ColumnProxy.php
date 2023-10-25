<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Proxy;

use Application\Context\ReferenceBooks\Column\Repositories\ColumnRepository;
use Domain\Shared\ValueObjects\Id\Id;

interface ColumnProxy
{
    public function __construct(Id $referenceBookId, ColumnRepository $repository);

    public function get(): array;
}
