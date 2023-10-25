<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Factories;

class ReferenceBookCreationDraftFactory
{
    public static function object(): ReferenceBookCreationDraftBuilder
    {
        return new ReferenceBookCreationDraftBuilder();
    }
}
