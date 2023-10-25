<?php

namespace Application\Context\ReferenceBooks\Column\Actions;

use Domain\Context\ReferenceBooks\Column\Enums\DataTypeEnum;

class GetReferenceBookColumnDataTypesAction
{
    /**
     * @return array<DataTypeEnum>
     */
    public function run(): array
    {
        return DataTypeEnum::cases();
    }
}
