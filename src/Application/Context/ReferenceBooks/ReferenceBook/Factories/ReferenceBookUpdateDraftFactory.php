<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Factories;

class ReferenceBookUpdateDraftFactory
{
    public static function object(): ReferenceBookUpdateDraftBuilder
    {
        return new ReferenceBookUpdateDraftBuilder();
    }
}
