<?php

namespace Infrastructure\Context\ReferenceBooks\Column\Repositories;

use Application\Context\ReferenceBooks\Column\Factories\ColumnFactory;
use Application\Context\ReferenceBooks\Column\Repositories\ColumnCreationDraftRepository;
use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Context\ReferenceBooks\Column\Enums\DataTypeEnum;
use Domain\Context\ReferenceBooks\Column\ValueObjects\DataType\DataType;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Name\Name;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\EnumSettings;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\NumericSettings;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\StringSettings;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Width\Width;
use Domain\Shared\Enums\DraftType;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Support\Facades\DB;
use JsonException;
use ReflectionException;
use Throwable;

final class ColumnCreationDraftSqlRepository implements ColumnCreationDraftRepository
{
    /**
     * @param Id $referenceBookId
     * @return Column[]
     * @throws ReflectionException
     * @throws Throwable
     */
    public function allByReferenceBookId(Id $referenceBookId): array
    {
        $referenceBookCreationDraft = $this->getDraftObjectById($referenceBookId);

        if (is_null($referenceBookCreationDraft)) {
            return [];
        }

        $referenceBookCreationDraftBody = $this->getEncodedBodyObject($referenceBookCreationDraft->body);
        $rawColumns = $referenceBookCreationDraftBody->columns;
        $result = [];

        foreach ($rawColumns as $rawColumn) {
            $result[] = $this->map($rawColumn, $referenceBookId);
        }

        return $result;
    }

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    private function map(object $rawColumn, Id $referenceBookCreationDraftId): Column
    {
        if (is_string($rawColumn->settings)) {
            $settingsObject = json_decode($rawColumn->settings, false, 512, JSON_THROW_ON_ERROR);
        } else {
            $settingsObject = $rawColumn->settings;
        }
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
            ->withReferenceBookId($referenceBookCreationDraftId)
            ->withRequired($rawColumn->required)
            ->withSettings($settings)
            ->withWidth(new Width($rawColumn->width))
            ->restore();
    }

    private function getDraftObjectById(Id $id): ?object
    {
        return DB::table('drafts')
            ->where('id', $id)
            ->where('type', DraftType::ReferenceBookCreationDraft->value)
            ->first();
    }

    /**
     * @throws JsonException
     */
    private function getEncodedBodyObject(string $jsonBody): object
    {
        return json_decode(
            $jsonBody,
            false,
            JSON_UNESCAPED_UNICODE,
            JSON_THROW_ON_ERROR
        );
    }
}
