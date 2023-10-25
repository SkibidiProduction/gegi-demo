<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Code;

use Throwable;

class Code
{
    protected CodeValidator $validator;

    /**
     * @throws Throwable
     */
    public function __construct(private readonly string $code)
    {
        $this->validator = new CodeValidator();
        $this->validate();
    }

    public function value(): string
    {
        return $this->code;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    /**
     * @throws Throwable
     */
    protected function validate(): void
    {
        $this->check()->thatCodeHasNotUnsupportedSymbols($this->code);
        $this->check()->thatCodeNameIsNotTooShort($this->code);
        $this->check()->thatCodeNameIsNotTooLong($this->code);
    }

    protected function check(): CodeValidator
    {
        return $this->validator;
    }
}
