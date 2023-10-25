<?php

namespace Domain\Context\ReferenceBooks\Column\ValueObjects\Name;

use Throwable;

class Name
{
    protected NameValidator $validator;

    /**
     * @throws Throwable
     */
    public function __construct(protected readonly string $name)
    {
        $this->validator = new NameValidator();
        $this->validate();
    }

    public function value(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @throws Throwable
     */
    protected function validate(): void
    {
        $this->check()->thatNameIsNotTooShort($this->name);
        $this->check()->thatNameInNotTooLong($this->name);
    }

    protected function check(): NameValidator
    {
        return $this->validator;
    }
}
