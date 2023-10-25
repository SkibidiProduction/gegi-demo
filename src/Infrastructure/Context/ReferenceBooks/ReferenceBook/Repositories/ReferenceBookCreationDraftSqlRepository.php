<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories;

use Application\Context\ReferenceBooks\Column\Repositories\ColumnCreationDraftRepository;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Application\Context\ReferenceBooks\Row\Repositories\RowCreationDraftRepository;
use Application\Shared\Criteria\Criteria;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookCreationDraftNotFoundException;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\Column\Repositories\ColumnCreationDraftSqlRepository;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBookCreationDraft\DeleteReferenceBookCreationDraftCommand;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBookCreationDraft\InsertNewReferenceBookCreationDraftCommand;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBookCreationDraft\LockReferenceBookCreationDraftCommand;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBookCreationDraft\UnlockReferenceBookCreationDraftCommand;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Commands\Sql\ReferenceBookCreationDraft\UpdateReferenceBookCreationDraftCommand;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Queries\Sql\ReferenceBookCreationDraft\DataMappers\MapReferenceBookCreationDraftFromDBStructure;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Queries\Sql\ReferenceBookCreationDraft\GetReferenceBookCreationDraftByIdQuery;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Queries\Sql\ReferenceBookCreationDraft\GetReferenceBookCreationDraftByNameQuery;
use Infrastructure\Context\ReferenceBooks\Row\Repositories\RowCreationDraftSqlRepository;
use ReflectionException;
use Throwable;

class ReferenceBookCreationDraftSqlRepository implements ReferenceBookCreationDraftRepository
{
    public const DRAFTS_TABLE = 'drafts';
    public const LOCKS_TABLE = 'edit_locks';

    protected ?Criteria $criteria = null;
    protected ColumnCreationDraftSqlRepository $columnRepository;
    protected RowCreationDraftSqlRepository $rowRepository;

    //QUERIES

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    public function getById(Id $id): ?ReferenceBookCreationDraft
    {
        $rawReferenceBookCreationDraft = GetReferenceBookCreationDraftByIdQuery::run($id);

        return $rawReferenceBookCreationDraft
            ? MapReferenceBookCreationDraftFromDBStructure::run($rawReferenceBookCreationDraft, $this)
            : null;
    }

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    public function getByName(Name $name): ?ReferenceBookCreationDraft
    {
        /** @var object|null $rawReferenceBookCreationDraft */
        $rawReferenceBookCreationDraft = GetReferenceBookCreationDraftByNameQuery::run($name);

        return $rawReferenceBookCreationDraft
            ? MapReferenceBookCreationDraftFromDBStructure::run($rawReferenceBookCreationDraft, $this)
            : null;
    }

    /**
     * @param Id $id
     * @return ReferenceBookCreationDraft
     * @throws ReflectionException
     * @throws Throwable
     */
    public function findById(Id $id): ReferenceBookCreationDraft
    {
        $rawReferenceBook = GetReferenceBookCreationDraftByIdQuery::run($id);
        if (is_null($rawReferenceBook)) {
            throw new ReferenceBookCreationDraftNotFoundException();
        }
        return MapReferenceBookCreationDraftFromDBStructure::run($rawReferenceBook, $this);
    }

    public function columns(): ColumnCreationDraftRepository
    {
        if (!isset($this->columnRepository)) {
            $this->columnRepository = new ColumnCreationDraftSqlRepository();
        }

        return $this->columnRepository;
    }

    public function rows(): RowCreationDraftRepository
    {
        if (!isset($this->rowRepository)) {
            $this->rowRepository = new RowCreationDraftSqlRepository();
        }

        return $this->rowRepository;
    }

    //COMMANDS

    /**
     * @throws Throwable
     */
    public function insert(ReferenceBookCreationDraft $referenceBook): void
    {
        DB::transaction(static function () use ($referenceBook) {
            InsertNewReferenceBookCreationDraftCommand::run($referenceBook);
            if (!is_null($referenceBook->lockedBy())) {
                LockReferenceBookCreationDraftCommand::run($referenceBook);
            }
        });
    }

    /**
     * @throws Throwable
     */
    public function update(ReferenceBookCreationDraft $referenceBook): void
    {
        DB::transaction(static function () use ($referenceBook) {
            if (!is_null($referenceBook->lockedBy())) {
                LockReferenceBookCreationDraftCommand::run($referenceBook);
            } else {
                UnlockReferenceBookCreationDraftCommand::run($referenceBook->id());
            }

            UpdateReferenceBookCreationDraftCommand::run($referenceBook);
        });
    }

    /**
     * @throws Throwable
     */
    public function delete(Id $id): void
    {
        DB::transaction(static function () use ($id) {
            DeleteReferenceBookCreationDraftCommand::run($id);
            UnlockReferenceBookCreationDraftCommand::run($id);
        });
    }
}
