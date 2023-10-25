<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Dto;

use Application\Shared\Criteria\Filtrate;
use Application\Shared\Dto\DateTimeRangeDto;
use Carbon\Carbon;

interface GetReferenceBookListFiltersDto extends Filtrate
{
    public function getName(): ?string;
    public function getDescription(): ?string;
    public function getStatus(): ?string;
    public function getCreatedAtFrom(): ?Carbon;
    public function getCreatedAtTo(): ?Carbon;
    public function getUpdatedAtFrom(): ?Carbon;
    public function getUpdatedAtTo(): ?Carbon;
    public function getCreatedAtRange(): DateTimeRangeDto;
    public function getUpdatedAtRange(): DateTimeRangeDto;
}
