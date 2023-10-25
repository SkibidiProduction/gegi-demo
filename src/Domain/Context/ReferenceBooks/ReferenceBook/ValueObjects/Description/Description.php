<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Description;

use Throwable;

class Description
{
    protected DescriptionValidator $validator;

    public function __construct(protected readonly string $description)
    {
        $this->validator = new DescriptionValidator();
    }

    public function value(): string
    {
        return $this->description;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    /**
     * @return void
     * @throws Throwable
     */
    protected function validate(): void
    {
        $this->check()->thatDescriptionIsNotTooShort($this->description);
        $this->check()->thatDescriptionIsNotTooLong($this->description);
    }

    protected function check(): DescriptionValidator
    {
        return $this->validator;
    }
}
