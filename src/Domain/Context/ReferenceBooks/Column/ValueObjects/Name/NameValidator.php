<?php

namespace Domain\Context\ReferenceBooks\Column\ValueObjects\Name;

use Domain\Context\ReferenceBooks\Column\ValueObjects\Name\Exceptions\ColumnNameIsTooLongException;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Name\Exceptions\ColumnNameIsTooShortException;
use Throwable;

class NameValidator
{
    public const MINIMUM_LENGTH = 1;
    public const MAXIMUM_LENGTH = 32;

    /**
     * @throws Throwable
     */
    public function thatNameIsNotTooShort(string $name): void
    {
        if (mb_strlen($name) < self::MINIMUM_LENGTH) {
            throw new ColumnNameIsTooShortException(self::MINIMUM_LENGTH);
        }
    }

    /**
     * @throws Throwable
     */
    public function thatNameInNotTooLong(string $name): void
    {
        if (mb_strlen($name) > self::MAXIMUM_LENGTH) {
            throw new ColumnNameIsTooLongException(self::MAXIMUM_LENGTH);
        }
    }
}
