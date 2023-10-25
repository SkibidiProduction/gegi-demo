<?php

namespace Domain\Context\ReferenceBooks\Column\Enums;

enum DataTypeEnum: string
{
    case String = 'string';
    case Numeric = 'numeric';
    case Enum = 'enum';
    case Date = 'date';
}
