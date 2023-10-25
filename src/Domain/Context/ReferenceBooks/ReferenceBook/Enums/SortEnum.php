<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Enums;

enum SortEnum: string
{
    case Name = 'name';
    case Status = 'status';
    case UpdatedAt = 'updatedAt';

    case CreatedAt = 'createdAt';
    case Description = 'description';
}
