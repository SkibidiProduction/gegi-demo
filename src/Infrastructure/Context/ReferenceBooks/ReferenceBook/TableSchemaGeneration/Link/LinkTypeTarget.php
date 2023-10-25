<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\Link;

enum LinkTypeTarget: string
{
    case Blank = '__blank';

    case Self = '__self';
}
