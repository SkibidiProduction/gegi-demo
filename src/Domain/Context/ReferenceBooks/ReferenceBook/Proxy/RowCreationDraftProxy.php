<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Proxy;

use Domain\Context\ReferenceBooks\Row\Row;

interface RowCreationDraftProxy
{
    /**
     * @return array<Row>
     */
    public function get(): array;
}
