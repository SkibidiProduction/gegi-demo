<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Proxy;

use Domain\Context\ReferenceBooks\Row\Row;

interface RowUpdateDraftProxy
{
    /**
     * @return array<Row>
     */
    public function get(): array;
}
