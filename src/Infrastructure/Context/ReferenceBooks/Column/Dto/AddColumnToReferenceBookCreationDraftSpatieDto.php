<?php

namespace Infrastructure\Context\ReferenceBooks\Column\Dto;

use Application\Context\ReferenceBooks\Column\Dto\AddColumnToReferenceBookCreationDraftDto;
use Application\Shared\Dto\Trackable;
use Domain\Context\ReferenceBooks\Column\Enums\DataTypeEnum;
use Domain\Context\ReferenceBooks\Column\ValueObjects\DataType\DataType;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Name\Name;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\EnumSettings;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\NumericSettings;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\Settings;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\StringSettings;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Width\Width;
use Domain\Shared\ValueObjects\Id\Id;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;
use Throwable;

class AddColumnToReferenceBookCreationDraftSpatieDto extends DataTransferObject implements AddColumnToReferenceBookCreationDraftDto, Trackable
{
    #[MapFrom('id')]
    public string|Id $referenceBookId;
    public string|Name $name;
    public int|Width $width;
    public ColumnSettingsSpatieDto|Settings|null $columnSettings;
    public string|DataType $dataType;
    public bool $isRequired = false;

    /**
     * @throws Throwable
     */
    public function trackData(): array
    {
        return [
            'name' => $this->getName(),
        ];
    }

    /**
     * @throws Throwable
     */
    public function getReferenceBookId(): Id
    {
        if (!$this->referenceBookId instanceof Id) {
            $this->referenceBookId = new Id($this->referenceBookId);
        }

        return $this->referenceBookId;
    }

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
    public function getWidth(): Width
    {
        if (!$this->width instanceof Width) {
            $this->width = new Width($this->width);
        }

        return $this->width;
    }

    /**
     * @throws Throwable
     */
    public function getColumnSettings(): ?Settings
    {
        if (!$this->columnSettings instanceof Settings) {
            $this->columnSettings = match ($this->getDataType()->value()) {
                DataTypeEnum::String->value => new StringSettings(
                    $this->columnSettings->getStringSettings()?->getMinCharCount(),
                    $this->columnSettings->getStringSettings()?->getMaxCharCount(),
                ),
                DataTypeEnum::Numeric->value => new NumericSettings(
                    $this->columnSettings->getNumericSettings()?->getMin(),
                    $this->columnSettings->getNumericSettings()?->getMax(),
                ),
                DataTypeEnum::Enum->value => new EnumSettings(
                    $this->columnSettings->getEnumSettings()?->getReferenceBookColumnId(),
                ),
                default => null,
            };
        }

        return $this->columnSettings;
    }

    public function getDataType(): DataType
    {
        if (!$this->dataType instanceof DataType) {
            $this->dataType = new DataType(DataTypeEnum::from($this->dataType));
        }
        return $this->dataType;
    }

    /**
     * @throws Throwable
     */

    public function getIsRequired(): bool
    {
        return $this->isRequired;
    }
}
