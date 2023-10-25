<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name;

use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Exceptions\ReferenceBookNameIsTooLongException;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Exceptions\ReferenceBookNameIsTooShortException;
use Throwable;

class NameValidator
{
    public const MINIMUM_LENGTH = 3;
    public const MAXIMUM_LENGTH = 100;

    /**
     * @throws Throwable
     */
    public function thatNameIsNotTooShort(string $name): void
    {
        if (mb_strlen($name) < self::MINIMUM_LENGTH) {
            throw new ReferenceBookNameIsTooShortException(self::MINIMUM_LENGTH);
        }
    }

    /**
     * @throws Throwable
     */
    public function thatNameIsNotTooLong(string $name): void
    {
        if (mb_strlen($name) > self::MAXIMUM_LENGTH) {
            throw new ReferenceBookNameIsTooLongException(self::MAXIMUM_LENGTH);
        }
    }
}
