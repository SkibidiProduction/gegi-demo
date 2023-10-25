<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Status;

use Carbon\Carbon;
use Domain\Context\ReferenceBooks\ReferenceBook\Enums\StatusEnum;
use Domain\Shared\ValueObjects\Id\Id;

class Status
{
    public function __construct(
        protected readonly StatusEnum $status,
        protected readonly ?Id $setBy = null,
        protected readonly ?Carbon $setAt = null,
    ) {
    }

    public function value(): string
    {
        return $this->status->value;
    }

    public function setBy(): ?Id
    {
        return $this->setBy;
    }

    public function setAt(): ?Carbon
    {
        return $this->setAt;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function asEnum(): StatusEnum
    {
        return $this->status;
    }
}
