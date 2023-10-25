<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Proxy;

use Application\Context\ReferenceBooks\Column\Repositories\ColumnCreationDraftRepository;
use Domain\Shared\ValueObjects\Id\Id;

interface ColumnCreationDraftProxy
{
    public function __construct(Id $referenceBookId, ColumnCreationDraftRepository $repository);

    public function get(): array;
}
