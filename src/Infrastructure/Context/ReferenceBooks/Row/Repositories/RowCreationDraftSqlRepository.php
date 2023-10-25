<?php

namespace Infrastructure\Context\ReferenceBooks\Row\Repositories;

use Application\Context\ReferenceBooks\Row\Factories\RowFactory;
use Application\Context\ReferenceBooks\Row\Repositories\RowCreationDraftRepository;
use Application\Shared\Criteria\Criteria;
use Application\Shared\Utilities\Paginator\Paginator;
use Domain\Context\ReferenceBooks\Row\Row;
use Domain\Context\ReferenceBooks\Row\ValueObjects\Value;
use Domain\Shared\Enums\DraftType;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Support\Facades\DB;
use JsonException;
use ReflectionException;
use Throwable;

final class RowCreationDraftSqlRepository implements RowCreationDraftRepository
{
    public function match(Criteria $criteria): RowCreationDraftRepository
    {
        return $this;
    }

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    public function getPaginated(int $page, int $limit, Id $referenceBookId): Paginator
    {
        $referenceBookCreationDraft = $this->getDraftObjectById($referenceBookId);

        if (is_null($referenceBookCreationDraft)) {
            return new Paginator(
                data: [],
                total: 0,
                perPage: $limit,
                currentPage: $page,
                lastPage: 1,
            );
        }

        $referenceBookCreationDraftBody = $this->getEncodedBodyObject($referenceBookCreationDraft->body);
        $rawRowsPages = array_chunk($referenceBookCreationDraftBody['rows'], $limit);

        $result = !empty($rawRowsPages)
            ? $this->getRowItems(
                $referenceBookId,
                $rawRowsPages[$page - 1],
                $referenceBookCreationDraftBody['values']
            )
            : []
        ;

        return new Paginator(
            data: $result,
            total: count($referenceBookCreationDraftBody['rows']),
            perPage: $limit,
            currentPage: $page,
            lastPage: array_key_last($rawRowsPages) + 1,
        );
    }

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    public function getAllByReferenceBookId(Id $referenceBookId): array
    {
        $referenceBookCreationDraft = $this->getDraftObjectById($referenceBookId);

        if (is_null($referenceBookCreationDraft)) {
            return [];
        }

        $referenceBookCreationDraftBody = $this->getEncodedBodyObject($referenceBookCreationDraft->body);
        $rawRows = $referenceBookCreationDraftBody['rows'];

        return $this->getRowItems(
            $referenceBookId,
            $rawRows,
            $referenceBookCreationDraftBody['values']
        );
    }

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    private function map(array $rawRow): Row
    {
        return RowFactory::object()
            ->withId(new Id($rawRow['id']))
            ->withReferenceBookId($rawRow['reference_book_id'])
            ->withValues($rawRow['values'])
            ->restore();
    }

    public function getValuesByColumnId(Id $columnId): array
    {
        return [];
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
    private function getEncodedBodyObject(string $jsonBody): array
    {
        return json_decode(
            $jsonBody,
            true,
            JSON_UNESCAPED_UNICODE,
            JSON_THROW_ON_ERROR
        );
    }

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    private function getRowItems(Id $referenceBookId, array $rawRows, array $values): array
    {
        $result = [];

        foreach ($rawRows as $rawRow) {
            $rawRowValues = array_filter(
                $values,
                fn (array $value) => $value['reference_book_row_id'] === $rawRow['id']
            );

            $items = [];

            foreach ($rawRowValues as $rawRowValue) {
                $value = new Value($rawRowValue['value'], new Id($rawRowValue['reference_book_column_id']));
                $value->setRowId(new Id($rawRow['id']));
                $items[] = $value;
            }

            $rawRow['values'] = $items;
            $rawRow['reference_book_id'] = $referenceBookId;
            $result[] = $this->map($rawRow);
        }

        return $result;
    }
}
