<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Dto;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\CreateReferenceBookCreationDraftDto;
use Application\Shared\Dto\Trackable;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Code\Code;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class CreateReferenceBookCreationDraftSpatieDto extends DataTransferObject implements CreateReferenceBookCreationDraftDto, Trackable
{
    public string|Name $name;

    public string|Id $userId;

    public ?Code $code = null;

    /**
     * @throws Throwable
     */
    public function getName(): Name
    {
        if (!$this->name instanceof Name) {
            $this->name = new Name($this->name);
        }

        return $this->name;
    }

    /**
     * @throws Throwable
     */
    public function getCode(): Code
    {
        if (is_null($this->code)) {
            $this->code = new Code(Str::slug($this->getName()->value(), '_'));
        }

        return $this->code;
    }

    /**
     * @throws Throwable
     */
    public function getUserId(): Id
    {
        if (!$this->userId instanceof Id) {
            $this->userId = new Id($this->userId);
        }

        return $this->userId;
    }

    /**
     * @throws Throwable
     */
    public function trackData(): array
    {
        return [
            'name' => $this->getName(),
        ];
    }
}
