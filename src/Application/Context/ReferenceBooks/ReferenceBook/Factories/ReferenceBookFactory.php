<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Factories;

class ReferenceBookFactory
{
    public static function object(): ReferenceBookBuilder
    {
        return new ReferenceBookBuilder();
    }
}
