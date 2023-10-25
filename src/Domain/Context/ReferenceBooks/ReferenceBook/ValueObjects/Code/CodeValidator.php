<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Code;

use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Code\Exceptions\ReferenceBookCodeHasUnsupportedSymbolsException;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Code\Exceptions\ReferenceBookCodeIsTooLongException;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Code\Exceptions\ReferenceBookCodeIsTooShortException;
use Throwable;

class CodeValidator
{
    private const MINIMUM_LENGTH = 3;
    private const MAXIMUM_LENGTH = 255;

    /**
     * @throws Throwable
     */
    public function thatCodeHasNotUnsupportedSymbols(string $code): void
    {
        if (!preg_match('/^[a-z_0-9]+$/', $code)) {
            throw new ReferenceBookCodeHasUnsupportedSymbolsException();
        }
    }

    /**
     * @throws Throwable
     */
    public function thatCodeNameIsNotTooShort(string $code): void
    {
        if (mb_strlen($code) < self::MINIMUM_LENGTH) {
            throw new ReferenceBookCodeIsTooShortException(self::MINIMUM_LENGTH);
        }
    }

    /**
     * @throws Throwable
     */
    public function thatCodeNameIsNotTooLong(string $code): void
    {
        if (mb_strlen($code) > self::MAXIMUM_LENGTH) {
            throw new ReferenceBookCodeIsTooLongException(self::MAXIMUM_LENGTH);
        }
    }
}
