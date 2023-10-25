<?php

namespace Domain\Context\ReferenceBooks\Column\ValueObjects\Width;

use Throwable;

class Width
{
    protected WidthValidator $validator;

    /**
     * @throws Throwable
     */
    public function __construct(protected readonly int $width)
    {
        $this->validator = new WidthValidator();
        $this->validate();
    }

    public function value(): int
    {
        return $this->width;
    }

    /**
     * @throws Throwable
     */
    protected function validate(): void
    {
        $this->check()->thatWidthIsNotTooSmall($this->width);
        $this->check()->thatWidthIsNotTooBig($this->width);
    }

    protected function check(): WidthValidator
    {
        return $this->validator;
    }
}
