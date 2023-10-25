<?php

namespace Application\Context\ReferenceBooks\Column\Factories;

class ColumnFactory
{
    public static function object(): ColumnBuilder
    {
        return new ColumnBuilder();
    }
}
