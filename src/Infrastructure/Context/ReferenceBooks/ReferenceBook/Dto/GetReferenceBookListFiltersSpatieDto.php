<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Dto;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\GetReferenceBookListFiltersDto;
use Application\Shared\Dto\DateTimeRangeDto;
use Carbon\Carbon;
use Infrastructure\Shared\Dto\DateTimeRangeSpatieDto;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Throwable;

class GetReferenceBookListFiltersSpatieDto extends DataTransferObject implements GetReferenceBookListFiltersDto
{
    public ?string $name = null;
    public ?string $description = null;
    public ?string $status = null;
    public ?array $createdAt = [];
    public ?array $updatedAt = [];

    /**
     * @throws Throwable
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @throws UnknownProperties
     */
    public function getCreatedAtRange(): DateTimeRangeDto
    {
        return new DateTimeRangeSpatieDto($this->createdAt);
    }

    /**
     * @throws UnknownProperties
     */
    public function getUpdatedAtRange(): DateTimeRangeDto
    {
        return new DateTimeRangeSpatieDto($this->updatedAt);
    }

    public function getCreatedAtFrom(): ?Carbon
    {
        return isset($this->createdAt['from']) ? Carbon::parse($this->createdAt['from']) : null;
    }

    public function getCreatedAtTo(): ?Carbon
    {
        return isset($this->createdAt['to']) ? Carbon::parse($this->createdAt['to']) : null;
    }

    public function getUpdatedAtFrom(): ?Carbon
    {
        return isset($this->updatedAt['from']) ? Carbon::parse($this->updatedAt['from']) : null;
    }

    public function getUpdatedAtTo(): ?Carbon
    {
        return isset($this->updatedAt['to']) ? Carbon::parse($this->updatedAt['to']) : null;
    }
}
