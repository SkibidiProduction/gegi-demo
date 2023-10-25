<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Proxy;

use Domain\Context\ReferenceBooks\Column\Column;

interface ColumnUpdateDraftProxy
{
    /**
     * @return array<Column>
     */
    public function get(): array;
}
