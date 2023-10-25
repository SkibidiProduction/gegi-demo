<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Proxy;

use Application\Context\ReferenceBooks\Row\Repositories\RowRepository;
use Domain\Shared\ValueObjects\Id\Id;

interface RowProxy
{
    public function __construct(Id $referenceBookId, RowRepository $repository);

    public function get(): array;
}
