<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories;

use Application\Context\ReferenceBooks\Column\Repositories\ColumnUpdateDraftRepository;
use Application\Context\ReferenceBooks\ReferenceBook\Factories\ReferenceBookUpdateDraftFactory;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookUpdateDraftRepository;
use Application\Context\ReferenceBooks\Row\Repositories\RowUpdateDraftRepository;
use Application\Shared\Criteria\Criteria;
use Application\Shared\Enums\EditLockType;
use Carbon\Carbon;
use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Context\ReferenceBooks\ReferenceBook\Enums\StatusEnum;
use Domain\Context\ReferenceBooks\ReferenceBook\Enums\TypeEnum;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookUpdateDraftNotFoundException;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookUpdateDraft;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Code\Code;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Description\Description;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\ReferenceBookType\Type;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Status\Status;
use Domain\Context\ReferenceBooks\Row\Row;
use Domain\Shared\Enums\DraftType;
use Domain\Shared\ValueObjects\Id\Id;
use Illuminate\Support\Facades\DB;
use Infrastructure\Context\ReferenceBooks\Column\Repositories\ColumnUpdateDraftSqlRepository;
use Infrastructure\Context\ReferenceBooks\Row\Repositories\RowUpdateDraftSqlRepository;
use JsonException;
use ReflectionException;
use Throwable;

class ReferenceBookUpdateDraftSqlRepository implements ReferenceBookUpdateDraftRepository
{
    protected ?Criteria $criteria = null;
    protected ColumnUpdateDraftSqlRepository $columnRepository;
    protected RowUpdateDraftSqlRepository $rowRepository;

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    public function getById(Id $id): ?ReferenceBookUpdateDraft
    {
        /** @var object|null $rawReferenceBookUpdateDraft */
        $rawReferenceBookUpdateDraft = $this->getDraftObjectById($id);

        return $rawReferenceBookUpdateDraft
            ? $this->map($rawReferenceBookUpdateDraft)
            : null
        ;
    }

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    public function getByName(Name $name): ?ReferenceBookUpdateDraft
    {
        /** @var object|null $rawReferenceBookUpdateDraft */
        $rawReferenceBookUpdateDraft = DB::table('drafts')
            ->where('type', DraftType::ReferenceBookUpdateDraft->value)
            ->where('name', $name)
            ->first()
        ;

        return $rawReferenceBookUpdateDraft
            ? $this->map($rawReferenceBookUpdateDraft)
            : null
        ;
    }

    /**
     * @param Id $id
     * @return ReferenceBookUpdateDraft
     * @throws ReflectionException
     * @throws Throwable
     */
    public function findById(Id $id): ReferenceBookUpdateDraft
    {
        $rawReferenceBook = $this->getDraftObjectById($id);
        if (is_null($rawReferenceBook)) {
            throw new ReferenceBookUpdateDraftNotFoundException();
        }
        return $this->map($rawReferenceBook);
    }

    public function columns(): ColumnUpdateDraftRepository
    {
        if (!isset($this->columnRepository)) {
            $this->columnRepository = new ColumnUpdateDraftSqlRepository();
        }

        return $this->columnRepository;
    }

    public function insert(ReferenceBookUpdateDraft $referenceBook): void
    {
        DB::table('drafts')->insert($this->mapToDBStructure($referenceBook));
    }

    public function update(ReferenceBookUpdateDraft $referenceBook): void
    {
        DB::transaction(function () use ($referenceBook) {
            if (!is_null($referenceBook->lockedBy())) {
                DB::table('edit_locks')->upsert(
                    [
                        'id' => Id::new(),
                        'edit_lockable_type' => EditLockType::ReferenceBookUpdateDraft->value,
                        'edit_lockable_id' => $referenceBook->id()->value(),
                        'user_id' => $referenceBook->lockedBy(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ],
                    ['edit_lockable_type', 'edit_lockable_id'],
                    ['edit_lockable_type', 'edit_lockable_id'],
                );
            } else {
                DB::table('edit_locks')
                    ->where('edit_lockable_type', EditLockType::ReferenceBookUpdateDraft->value)
                    ->where('edit_lockable_id', $referenceBook->id()->value())
                    ->delete();
            }

            DB::table('drafts')
                ->where('id', $referenceBook->id())
                ->where('type', DraftType::ReferenceBookUpdateDraft->value)
                ->update($this->mapToDBStructure($referenceBook));
        });
    }

    /**
     * @throws JsonException
     */
    private function mapToDBStructure(ReferenceBookUpdateDraft $referenceBook): array
    {
        return [
            'id' => $referenceBook->id()->value(),
            'type' => DraftType::ReferenceBookUpdateDraft->value,
            'name' => $referenceBook->name()->value(),
            'body' => json_encode([
                'code' => $referenceBook->code()->value(),
                'rows' => $this->mapToRowsDB($referenceBook->rows()),
                'type' => $referenceBook->type()->value(),
                'status' => $referenceBook->status()->value(),
                'current_status_set_by' => $referenceBook->status()->setBy()?->value(),
                'current_status_set_at' => $referenceBook->status()->setAt()?->toString(),
                'values' => $this->mapToValuesDB($referenceBook->rows()),
                'columns' => $this->mapToColumnsDB($referenceBook->columns()),
                'description' => $referenceBook->description()?->value(),
                'previous_status' => $referenceBook->statusPrevious()?->value(),
                'previous_status_set_by' => $referenceBook->statusPrevious()?->setBy()?->value(),
                'previous_status_set_at' => $referenceBook->statusPrevious()?->setAt()?->toString(),
            ], JSON_THROW_ON_ERROR, JSON_UNESCAPED_UNICODE),
            'created_by' => $referenceBook->createdBy()->value(),
            'updated_by' => $referenceBook->lockedBy()?->value(),
            'created_at' => $referenceBook->createdAt()->toString(),
            'updated_at' => $referenceBook->updatedAt()?->toString(),
        ];
    }

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    private function map(object $rawReferenceBookUpdateDraft): ReferenceBookUpdateDraft
    {
        $body = $this->getEncodedBodyObject($rawReferenceBookUpdateDraft->body);

        $description = empty($body->description)
            ? null
            : new Description($body->description);

        $lockedBy = DB::table('edit_locks')
            ->where('edit_lockable_type', EditLockType::ReferenceBookUpdateDraft->value)
            ->where('edit_lockable_id', $rawReferenceBookUpdateDraft->id)
            ->first();

        return ReferenceBookUpdateDraftFactory::object()
            ->withId(new Id($rawReferenceBookUpdateDraft->id))
            ->withStatus($this->mapToStatus($body))
            ->withStatusPrevious($this->mapToPreviousStatus($body))
            ->withCode(new Code($body->code))
            ->withName(new Name($rawReferenceBookUpdateDraft->name))
            ->withType(new Type(TypeEnum::from($body->type)))
            ->withDescription($description)
            ->withCreatedAt(Carbon::parse($rawReferenceBookUpdateDraft->created_at))
            ->withUpdatedAt(
                $rawReferenceBookUpdateDraft->updated_at
                    ? Carbon::parse($rawReferenceBookUpdateDraft->updated_at)
                    : null
            )
            ->withCreatedBy(new Id($rawReferenceBookUpdateDraft->created_by))
            ->withUpdatedBy(
                $rawReferenceBookUpdateDraft->updated_by
                    ? new Id($rawReferenceBookUpdateDraft->updated_by)
                    : null
            )
            ->withEditor($lockedBy ? new Id($lockedBy->user_id) : null)
            ->restore($this);
    }

    /**
     * @throws Throwable
     */
    private function mapToPreviousStatus(?object $body): ?Status
    {
        if (is_null($body->previous_status)) {
            return null;
        }

        if (!is_null($body->previous_status_set_at)) {
            $setAt = Carbon::parse($body->previous_status_set_at);
        }

        if (!is_null($body->previous_status_set_by)) {
            $setBy = new Id($body->previous_status_set_by);
        }

        return new Status(
            StatusEnum::from($body->previous_status),
            $setBy ?? null,
            $setAt ?? null,
        );
    }

    /**
     * @throws Throwable
     */
    private function mapToStatus(object $body): Status
    {
        if (!is_null($body->current_status_set_at)) {
            $setAt = Carbon::parse($body->current_status_set_at);
        }

        if (!is_null($body->current_status_set_by)) {
            $setBy = new Id($body->current_status_set_by);
        }

        return new Status(
            StatusEnum::from($body->status),
            $setBy ?? null,
            $setAt ?? null,
        );
    }

    /**
     * @param array<Column> $columns
     * @return array
     */
    private function mapToColumnsDB(array $columns): array
    {
        return array_map(fn (Column $column) => [
            'id' => $column->id()->value(),
            'name' => $column->name()->value(),
            'width' => $column->width()->value(),
            'required' => $column->isRequired(),
            'settings' => $column->settings()->toArray(),
            'data_type' => $column->dataType()->value(),
        ], $columns);
    }

    /**
     * @param array<Row> $rows
     * @return array
     */
    private function mapToValuesDB(array $rows): array
    {
        $values = [];
        foreach ($rows as $row) {
            foreach ($row->values() as $value) {
                $values[] = [
                    'reference_book_row_id' => $row->id()->value(),
                    'reference_book_column_id' => $value->columnId()->value(),
                    'value' => $value->value(),
                ];
            }
        }

        return $values;
    }

    private function mapToRowsDB(array $rows): array
    {
        return array_map(fn (Row $row) => [
            'id' => $row->id()->value(),
        ], $rows);
    }

    private function getDraftObjectById(Id $id): ?object
    {
        return DB::table('drafts')
            ->where('id', $id)
            ->where('type', DraftType::ReferenceBookUpdateDraft->value)
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

    public function rows(): RowUpdateDraftRepository
    {
        if (!isset($this->rowRepository)) {
            $this->rowRepository = new RowUpdateDraftSqlRepository();
        }

        return $this->rowRepository;
    }

    /**
     * @throws Throwable
     */
    public function delete(Id $id): void
    {
        DB::transaction(static function () use ($id) {
            DB::table('drafts')
                ->where('id', $id->value())
                ->where('type', DraftType::ReferenceBookUpdateDraft->value)
                ->delete()
            ;
            DB::table('edit_locks')
                ->where('edit_lockable_id', $id->value())
                ->where('edit_lockable_type', EditLockType::ReferenceBookUpdateDraft->value)
                ->delete();
        });
    }
}
