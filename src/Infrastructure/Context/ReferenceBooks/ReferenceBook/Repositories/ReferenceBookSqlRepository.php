<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories;

use Application\Context\ReferenceBooks\Column\Repositories\ColumnRepository;
use Application\Context\ReferenceBooks\ReferenceBook\Factories\ReferenceBookFactory;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookRepository;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookUpdateDraftRepository;
use Application\Context\ReferenceBooks\Row\Repositories\RowRepository;
use Application\Shared\Criteria\Criteria;
use Application\Shared\Utilities\Paginator\Paginator;
use Carbon\Carbon;
use Domain\Context\ReferenceBooks\ReferenceBook\Enums\StatusEnum;
use Domain\Context\ReferenceBooks\ReferenceBook\Enums\TypeEnum;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookNotFoundException;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBook;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Code\Code;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Description\Description;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\ReferenceBookType\Type;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Status\Status;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\Column\Repositories\ColumnSqlRepository;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBook\DeleteReferenceBookEditLockCommand;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBook\InsertNewReferenceBookCommand;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBook\UpdateReferenceBookCommand;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBook\UpsertReferenceBookColumnCommand;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBook\UpsertReferenceBookEditLockCommand;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBook\UpsertReferenceBookRowCommand;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBook\UpsertReferenceBookValueCommand;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Queries\Sql\ReferenceBook\GetLockByReferenceBookIdQuery;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Queries\Sql\ReferenceBook\GetReferenceBookByIdQuery;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Queries\Sql\ReferenceBook\GetReferenceBookByNameQuery;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Queries\Sql\ReferenceBook\ReferenceBookQuery;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Queries\Sql\ReferenceBook\ReferenceBookWhereIdQuery;
use Infrastructure\Context\ReferenceBooks\Row\Repositories\RowSqlRepository;
use Infrastructure\Shared\Repositories\SqlCriterion\SqlCriterion;
use ReflectionException;
use Throwable;

class ReferenceBookSqlRepository implements ReferenceBookRepository
{
    public const MAIN_TABLE = 'reference_books';
    public const COLUMNS_TABLE = 'reference_book_columns';
    public const VALUES_TABLE = 'reference_book_values';
    public const LOCKS_TABLE = 'edit_locks';

    protected ?Criteria $criteria = null;
    protected ColumnRepository $columnRepository;
    protected RowRepository $rowRepository;
    protected ReferenceBookCreationDraftRepository $creationDraftsRepository;
    protected ReferenceBookUpdateDraftRepository $updateDraftsRepository;

    //QUERIES

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    public function getById(Id $id): ?ReferenceBook
    {
        $result = GetReferenceBookByIdQuery::run($id);

        if (is_null($result)) {
            return null;
        }

        return $this->map($result);
    }

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    public function getByName(Name $name): ?ReferenceBook
    {
        $result = GetReferenceBookByNameQuery::run($name);

        if (!is_null($result)) {
            $result = $this->map($result);
        }

        return $result;
    }

    /**
     * @param Id $id
     * @return ReferenceBook
     * @throws ReflectionException
     * @throws Throwable
     */
    public function findById(Id $id): ReferenceBook
    {
        $query = ReferenceBookWhereIdQuery::run($id);
        $rawReferenceBook = $this->applyFilters($query)->first();
        if (is_null($rawReferenceBook)) {
            throw new ReferenceBookNotFoundException();
        }
        return $this->map($rawReferenceBook);
    }

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    public function getPaginated(int $page, int $limit): Paginator
    {
        $result = [];

        $query = ReferenceBookQuery::run();
        $totalItems = $this->count($query);

        $query->offset($page * $limit - $limit)->limit($limit);
        $rawReferenceBooks = $this->applyFilters($query)->get();

        foreach ($rawReferenceBooks as $rawReferenceBook) {
            $result[] = $this->map($rawReferenceBook);
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

    public function columns(): ColumnRepository
    {
        if (!isset($this->columnRepository)) {
            $this->columnRepository = new ColumnSqlRepository();
        }

        return $this->columnRepository;
    }

    public function rows(): RowRepository
    {
        if (!isset($this->rowRepository)) {
            $this->rowRepository = new RowSqlRepository();
        }

        return $this->rowRepository;
    }

    public function creationDrafts(): ReferenceBookCreationDraftRepository
    {
        if (!isset($this->creationDraftsRepository)) {
            $this->creationDraftsRepository = new ReferenceBookCreationDraftSqlRepository();
        }

        return $this->creationDraftsRepository;
    }

    public function updateDrafts(): ReferenceBookUpdateDraftRepository
    {
        if (!isset($this->updateDraftsRepository)) {
            $this->updateDraftsRepository = new ReferenceBookUpdateDraftSqlRepository();
        }

        return $this->updateDraftsRepository;
    }

    //CHAINS

    public function match(Criteria $criteria): ReferenceBookRepository
    {
        $this->criteria = $criteria;
        return $this;
    }

    //COMMANDS

    /**
     * @throws Throwable
     */
    public function insert(ReferenceBook $referenceBook): void
    {
        DB::transaction(static function () use ($referenceBook) {
            InsertNewReferenceBookCommand::run($referenceBook);

            foreach ($referenceBook->columns() as $column) {
                UpsertReferenceBookColumnCommand::run($referenceBook->id(), $column);
            }

            foreach ($referenceBook->rows() as $row) {
                UpsertReferenceBookRowCommand::run($referenceBook->id(), $row);
                foreach ($row->values() as $rowValue) {
                    UpsertReferenceBookValueCommand::run($rowValue);
                }
            }
        });
    }

    /**
     * @throws Throwable
     */
    public function update(ReferenceBook $referenceBook): void
    {
        DB::transaction(static function () use ($referenceBook) {
            if (!is_null($referenceBook->lockedBy())) {
                UpsertReferenceBookEditLockCommand::run($referenceBook);
            } else {
                DeleteReferenceBookEditLockCommand::run($referenceBook->id());
            }

            UpdateReferenceBookCommand::run($referenceBook);

            foreach ($referenceBook->columns() as $column) {
                UpsertReferenceBookColumnCommand::run($referenceBook->id(), $column);
            }

            foreach ($referenceBook->rows() as $row) {
                UpsertReferenceBookRowCommand::run($referenceBook->id(), $row);
                foreach ($row->values() as $rowValue) {
                    UpsertReferenceBookValueCommand::run($rowValue);
                }
            }
        });
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

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    private function map(object $rawReferenceBook): ReferenceBook
    {
        $lock = GetLockByReferenceBookIdQuery::run(new Id($rawReferenceBook->id));

        $statusPrevious = is_null($rawReferenceBook->previous_status)
            ? null
            : new Status(StatusEnum::from($rawReferenceBook->previous_status));
        $description = empty($rawReferenceBook->description)
            ? null
            : new Description($rawReferenceBook->description);

        return ReferenceBookFactory::object()
            ->withId(new Id($rawReferenceBook->id))
            ->withStatus(new Status(StatusEnum::from($rawReferenceBook->status)))
            ->withStatusPrevious($statusPrevious)
            ->withCode(new Code($rawReferenceBook->code))
            ->withName(new Name($rawReferenceBook->name))
            ->withType(new Type(TypeEnum::from($rawReferenceBook->type)))
            ->withDescription($description)
            ->withCreatedAt(Carbon::parse($rawReferenceBook->created_at))
            ->withUpdatedAt($rawReferenceBook->updated_at ? Carbon::parse($rawReferenceBook->updated_at) : null)
            ->withCreatedBy($rawReferenceBook->created_by ? new Id($rawReferenceBook->created_by) : null)
            ->withUpdatedBy($rawReferenceBook->updated_by ? new Id($rawReferenceBook->updated_by) : null)
            ->withEditor(!is_null($lock) ? new Id($lock->user_id) : null)
            ->restore($this);
    }
}
