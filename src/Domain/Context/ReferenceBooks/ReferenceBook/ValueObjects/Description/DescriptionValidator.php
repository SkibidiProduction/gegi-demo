<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Description;

use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Exceptions\ReferenceBookDescriptionIsTooLongException;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Exceptions\ReferenceBookDescriptionIsTooShortException;
use Throwable;

class DescriptionValidator
{
    public const MINIMUM_LENGTH = 1;
    public const MAXIMUM_LENGTH = 500;

    /**
     * @throws Throwable
     */
    public function thatDescriptionIsNotTooShort(string $name): void
    {
        if (mb_strlen($name) < self::MINIMUM_LENGTH) {
            throw new ReferenceBookDescriptionIsTooShortException(self::MINIMUM_LENGTH);
        }
    }

    /**
     * @throws Throwable
     */
    public function thatDescriptionIsNotTooLong(string $name): void
    {
        if (mb_strlen($name) > self::MAXIMUM_LENGTH) {
            throw new ReferenceBookDescriptionIsTooLongException(self::MAXIMUM_LENGTH);
        }
    }
}
