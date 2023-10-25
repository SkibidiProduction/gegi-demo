<?php

namespace Infrastructure\Context\ReferenceBooks\Column\Repositories;

use Application\Context\ReferenceBooks\Column\Factories\ColumnFactory;
use Application\Context\ReferenceBooks\Column\Repositories\ColumnRepository;
use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Context\ReferenceBooks\Column\Enums\DataTypeEnum;
use Domain\Context\ReferenceBooks\Column\ValueObjects\DataType\DataType;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Name\Name;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\EnumSettings;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\NumericSettings;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\StringSettings;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Width\Width;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Support\Facades\DB;
use ReflectionException;
use Throwable;

class ColumnSqlRepository implements ColumnRepository
{
    public function allByReferenceBookId(Id $referenceBookId): array
    {
        $result = [];
        $rawColumns = DB::table('reference_book_columns')
            ->where('reference_book_id', $referenceBookId->value())
            ->get();

        foreach ($rawColumns as $rawColumn) {
            $result[] = $this->map($rawColumn);
        }

        return $result;
    }

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    protected function map(object $rawColumn): Column
    {
        $settingsObject = json_decode($rawColumn->settings, false, 512, JSON_THROW_ON_ERROR);
        $settings = match ($rawColumn->data_type) {
            DataTypeEnum::String->value => new StringSettings(
                $settingsObject->minCharactersNumber,
                $settingsObject->maxCharactersNumber
            ),
            DataTypeEnum::Numeric->value => new NumericSettings(
                $settingsObject->min,
                $settingsObject->max,
            ),
            DataTypeEnum::Enum->value => new EnumSettings(
                $settingsObject->columnId,
            ),
            default => null
        };

        return ColumnFactory::object()
            ->withId(new Id($rawColumn->id))
            ->withName(new Name($rawColumn->name))
            ->withDataType(new DataType(DataTypeEnum::from($rawColumn->data_type)))
            ->withReferenceBookId(new Id($rawColumn->reference_book_id))
            ->withRequired($rawColumn->required)
            ->withSettings($settings)
            ->withWidth(new Width($rawColumn->width))
            ->restore();
    }
}
