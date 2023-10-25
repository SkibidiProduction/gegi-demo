<?php

namespace Domain\Context\ReferenceBooks\Column;

use Domain\Context\ReferenceBooks\Column\Enums\DataTypeEnum;
use Domain\Context\ReferenceBooks\Column\Validators\ColumnValidator;
use Domain\Context\ReferenceBooks\Column\ValueObjects\DataType\DataType;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Name\Name;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\Settings;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\StringSettings;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Width\Width;
use Domain\Shared\ValueObjects\Id\Id;
use Throwable;

final class Column
{
    public const BASE_COLUMN_NAME = 'UUID';

    private Id $id;
    private Id $referenceBookId;
    private ColumnValidator $validator;

    //CONSTRUCTORS

    /**
     * @throws Throwable
     */
    public function __construct(
        private readonly Name $name,
        private readonly DataType $dataType,
        private readonly Width $width,
        private readonly ?Settings $settings,
        private readonly bool $isRequired,
        private readonly mixed $defaultValue = null
    ) {
        $this->validator = new ColumnValidator();
        $this->validate()->thatColumnCantHaveAnEmptyValueIfItsRequiredAndNotUuid(
            $this->isRequired,
            $this->defaultValue,
            $this->name
        );
        $this->id = Id::new();
    }

    /**
     * @return Column
     * @throws Throwable
     */
    public static function createUuidOne(): Column
    {
        return new self(
            name: new Name(self::BASE_COLUMN_NAME),
            dataType: new DataType(DataTypeEnum::String),
            width: new Width(50),
            settings: new StringSettings(36, 36),
            isRequired: true
        );
    }

    //ACCESSORS

    public function id(): Id
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function dataType(): DataType
    {
        return $this->dataType;
    }

    public function width(): Width
    {
        return $this->width;
    }

    public function settings(): ?Settings
    {
        return $this->settings;
    }

    public function isRequired(): bool
    {
        return $this->isRequired;
    }

    public function defaultValue(): mixed
    {
        return $this->defaultValue;
    }

    //MUTATORS

    /**
     * @throws Throwable
     */
    public function setReferenceBookId(Id $referenceBookId): Column
    {
        $currentReferenceBookId = $this->getCurrentReferenceBookId();
        $this->validate()->thatReferenceBookIdCantBeChangedWhenItAlreadySet($currentReferenceBookId, $referenceBookId);
        $this->referenceBookId = $referenceBookId;
        return $this;
    }

    //PRIVATE

    private function validate(): ColumnValidator
    {
        return $this->validator;
    }

    private function getCurrentReferenceBookId(): ?Id
    {
        return $this->referenceBookId ?? null;
    }
}
