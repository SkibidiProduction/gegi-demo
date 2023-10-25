<?php

namespace Domain\Context\ReferenceBooks\Column\ValueObjects\Width;

use Domain\Context\ReferenceBooks\Column\ValueObjects\Width\Exceptions\ColumnWidthTooBigException;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Width\Exceptions\ColumnWidthTooSmallException;
use Throwable;

class WidthValidator
{
    public const MIN_VALUE = 1;
    public const MAX_VALUE = 1000;

    /**
     * @throws Throwable
     */
    public function thatWidthIsNotTooSmall(int $width): void
    {
        if ($width < self::MIN_VALUE) {
            throw new ColumnWidthTooSmallException(self::MIN_VALUE);
        }
    }

    /**
     * @throws Throwable
     */
    public function thatWidthIsNotTooBig(int $width): void
    {
        if ($width > self::MAX_VALUE) {
            throw new ColumnWidthTooBigException(self::MAX_VALUE);
        }
    }
}
