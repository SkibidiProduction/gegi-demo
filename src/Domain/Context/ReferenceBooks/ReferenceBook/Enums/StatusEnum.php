<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Enums;

enum StatusEnum: string
{
    case New = 'new';
    case Active = 'active';
    case Archive = 'archive';
}
