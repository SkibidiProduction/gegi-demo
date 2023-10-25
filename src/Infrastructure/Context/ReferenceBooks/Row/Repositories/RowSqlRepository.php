<?php

namespace Infrastructure\Context\ReferenceBooks\Row\Repositories;

use Application\Context\ReferenceBooks\Row\Factories\RowFactory;
use Application\Context\ReferenceBooks\Row\Repositories\RowRepository;
use Application\Shared\Criteria\Criteria;
use Application\Shared\Utilities\Paginator\Paginator;
use Domain\Context\ReferenceBooks\Row\Row;
use Domain\Context\ReferenceBooks\Row\ValueObjects\Value;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Infrastructure\Shared\Repositories\SqlCriterion\SqlCriterion;
use ReflectionException;
use Throwable;

class RowSqlRepository implements RowRepository
{
    protected ?Criteria $criteria = null;

    /**
     * @return array<Row>
     * @throws ReflectionException
     * @throws Throwable
     */
    public function getAllByReferenceBookId(Id $referenceBookId): array
    {
        $result = [];
        $rawColumns = DB::table('reference_book_rows')
            ->select('reference_book_rows.*', DB::raw('COALESCE(json_agg(reference_book_values.*), \'[]\') as values'))
            ->leftJoin(
                'reference_book_values',
                'reference_book_values.reference_book_row_id',
                '=',
                'reference_book_rows.id'
            )
            ->where('reference_book_id', $referenceBookId->value())
            ->groupBy('reference_book_rows.id')
            ->get();

        foreach ($rawColumns as $rawColumn) {
            $values = [];
            $valuesList = json_decode($rawColumn->values, false);
            foreach ($valuesList as $rawValue) {
                $value = new Value($rawValue->value, new Id($rawValue->reference_book_column_id));
                $value->setRowId(new Id($rawValue->reference_book_row_id));
                $values[] = $value;
            }
            $rawColumn->values = $values;
            $result[] = $this->map($rawColumn);
        }

        return $result;
    }

    /**
     * @throws ReflectionException
     */
    protected function map(object $rawColumn): Row
    {
        return RowFactory::object()
            ->withId(new Id($rawColumn->id))
            ->withReferenceBookId(new Id($rawColumn->reference_book_id))
            ->withValues($rawColumn->values)
            ->restore();
    }

    public function match(Criteria $criteria): RowRepository
    {
        $this->criteria = $criteria;
        return $this;
    }

    public function getPaginated(int $page, int $limit, Id $referenceBookId): Paginator
    {
        $result = [];

        $query = DB::table('reference_book_rows')
            ->select('reference_book_rows.*', DB::raw('COALESCE(json_agg(reference_book_values.*), \'[]\') as values'))
            ->leftJoin(
                'reference_book_values',
                'reference_book_values.reference_book_row_id',
                '=',
                'reference_book_rows.id'
            )
            ->where('reference_book_id', $referenceBookId->value())
            ->groupBy('reference_book_rows.id');
        $totalItems = $this->count($query);

        $query->offset($page * $limit - $limit)->limit($limit);
        $rawRows = $this->applyFilters($query)->get();

        foreach ($rawRows as $rawRow) {
            $values = [];
            $valuesList = json_decode($rawRow->values, false);
            foreach ($valuesList as $rawValue) {
                $value = new Value($rawValue->value, new Id($rawValue->reference_book_column_id));
                $value->setRowId(new Id($rawValue->reference_book_row_id));
                $values[] = $value;
            }
            $rawRow->values = $values;
            $result[] = $this->map($rawRow);
        }

        $totalPages = (int)ceil($totalItems / $limit);

        return new Paginator(
            data: $result,
            total: $totalItems,
            perPage: $limit,
            currentPage: $page,
            lastPage: $totalPages
        );
    }

    /**
     * @return array<Value>
     * @throws Throwable
     */
    public function getValuesByColumnId(Id $columnId): array
    {
        $values = [];
        DB::table('reference_book_values')
            ->where('reference_book_column_id', $columnId->value())
            ->whereNotNull('value')
            ->get()
            ->each(function (object $value) use (&$values, $columnId) {
                $columnValue = new Value($value->value, $columnId);
                $columnValue->setRowId(new Id($value->reference_book_row_id));
                $values[] = $columnValue;
            });

        return $values;
    }

    private function count(Builder $builder): int
    {
        if (!is_null($this->criteria)) {
            foreach ($this->criteria->all() as $filter) {
                /** @var SqlCriterion $filter */
                $filter->setBuilder($builder)->apply();
            }
        }

        return $builder->count();
    }

    private function applyFilters(Builder $builder): Builder
    {
        if (!is_null($this->criteria)) {
            foreach ($this->criteria->all() as $filter) {
                /** @var SqlCriterion $filter */
                $filter->setBuilder($builder)->apply();
            }
        }

        return $builder;
    }
}
