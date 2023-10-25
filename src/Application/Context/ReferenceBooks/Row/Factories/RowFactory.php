<?php

namespace Application\Context\ReferenceBooks\Row\Factories;

class RowFactory
{
    public static function object(): RowBuilder
    {
        return new RowBuilder();
    }
}
