<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook;

use Carbon\Carbon;
use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Context\ReferenceBooks\ReferenceBook\Enums\StatusEnum;
use Domain\Context\ReferenceBooks\ReferenceBook\Enums\TypeEnum;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\CantAddRowWithNonExistingColumnException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookColumnAlreadyExistsException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookColumnDoesntExistException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowAlreadyExistsException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowNumericValueHasIncorrectFormatException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowStringValueHasIncorrectFormatException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowValuesHasWrongNumberException;
use Domain\Context\ReferenceBooks\ReferenceBook\Proxy\ColumnCreationDraftProxy;
use Domain\Context\ReferenceBooks\ReferenceBook\Proxy\RowCreationDraftProxy;
use Domain\Context\ReferenceBooks\ReferenceBook\Services\GetEachRowWithNewColumnDefaultValueService;
use Domain\Context\ReferenceBooks\ReferenceBook\Services\GetUuidColumnIdService;
use Domain\Context\ReferenceBooks\ReferenceBook\Validators\ReferenceBookCreationDraftValidator;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Code\Code;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Description\Description;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\ReferenceBookType\Type;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Status\Status;
use Domain\Context\ReferenceBooks\Row\Row;
use Domain\Shared\Aggregates\AggregateRoot;
use Domain\Shared\Aggregates\Lockable;
use Domain\Shared\Aggregates\LockTrait;
use Domain\Shared\Events\EventTrait;
use Domain\Shared\ValueObjects\Id\Id;
use Throwable;

final class ReferenceBookCreationDraft implements AggregateRoot, Lockable
{
    use EventTrait;
    use LockTrait;

    private Id $id;
    private Status $status;
    private ?Status $statusPrevious = null;
    private Carbon $createdAt;
    private ?Carbon $updatedAt;
    private ?Id $createdBy;
    private ?Id $updatedBy;
    private Type $type;
    private ?Description $description = null;

    /** @var ColumnCreationDraftProxy|array<Column> */
    private ColumnCreationDraftProxy|array $columns = [];

    /** @var RowCreationDraftProxy|array<Row> */
    private RowCreationDraftProxy|array $rows = [];
    private ReferenceBookCreationDraftValidator $validator;

    /**
     * @throws Throwable
     */
    public function __construct(
        private Name $name,
        private readonly Code $code,
        private readonly ?Id $userId
    ) {
        $this->validator = new ReferenceBookCreationDraftValidator();
        $uuidColumn = Column::createUuidOne();

        $this->id = Id::new();
        $this->type = new Type(TypeEnum::Custom);
        $this->status = new Status(StatusEnum::New);
        $this->createdAt = Carbon::now();
        $this->createdBy = $this->userId;
        $this->updatedAt = Carbon::now();
        $this->updatedBy = $this->userId;
        $this->addColumn($uuidColumn);
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

    public function code(): Code
    {
        return $this->code;
    }

    public function type(): Type
    {
        return $this->type;
    }

    public function status(): Status
    {
        return $this->status;
    }

    public function statusPrevious(): ?Status
    {
        return $this->statusPrevious;
    }

    public function description(): ?Description
    {
        return $this->description;
    }

    public function createdAt(): Carbon
    {
        return $this->createdAt;
    }

    public function createdBy(): Id
    {
        return $this->createdBy;
    }

    public function updatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }

    public function updatedBy(): ?Id
    {
        return $this->updatedBy;
    }

    /**
     * @throws ReferenceBookColumnDoesntExistException
     */
    public function uuidColumnId(): Id
    {
        return GetUuidColumnIdService::run($this->columns());
    }

    public function columns(): array
    {
        if ($this->columns instanceof ColumnCreationDraftProxy) {
            $this->columns = $this->columns->get();
        }
        return $this->columns;
    }

    public function rows(): array
    {
        if ($this->rows instanceof RowCreationDraftProxy) {
            $this->rows = $this->rows->get();
        }
        return $this->rows;
    }

    //MUTATORS

    public function updateName(Name $name): self
    {
        $this->name = $name;
        $this->update();
        return $this;
    }

    public function updateDescription(?Description $description): self
    {
        $this->description = $description;
        $this->update();
        return $this;
    }

    /**
     * @throws ReferenceBookColumnAlreadyExistsException
     * @throws Throwable
     */
    public function addColumn(Column $column): ReferenceBookCreationDraft
    {
        $this->validate()->thatNewColumnIsUnique($this->columns(), $column);
        $column->setReferenceBookId($this->id);
        $this->columns[] = $column;
        $this->rows = GetEachRowWithNewColumnDefaultValueService::run($this->rows(), $column);
        $this->update();
        return $this;
    }

    /**
     * @throws CantAddRowWithNonExistingColumnException
     * @throws ReferenceBookColumnDoesntExistException
     * @throws ReferenceBookRowAlreadyExistsException
     * @throws ReferenceBookRowNumericValueHasIncorrectFormatException
     * @throws ReferenceBookRowStringValueHasIncorrectFormatException
     * @throws ReferenceBookRowValuesHasWrongNumberException
     * @throws Throwable
     */
    public function addRow(Row $row): ReferenceBookCreationDraft
    {
        $this->validate()->thatRowContainsAsManyElementsAsThereAreColumns($row, count($this->columns()));
        $this->validate()->thatEveryColumnExists($row, $this->columns());
        $this->validate()->thatThereIsNoSuchRowYet($row, $this->rows());
        $this->validate()->thatRowContainsCorrectValues($row, $this->columns(), $this->uuidColumnId());

        $this->rows[] = $row;
        $this->update();

        return $this;
    }

    /**
     * @throws CantAddRowWithNonExistingColumnException
     * @throws ReferenceBookColumnDoesntExistException
     * @throws ReferenceBookRowAlreadyExistsException
     * @throws ReferenceBookRowNumericValueHasIncorrectFormatException
     * @throws ReferenceBookRowStringValueHasIncorrectFormatException
     * @throws ReferenceBookRowValuesHasWrongNumberException
     * @throws Throwable
     */
    public function updateRow(Row $row): ReferenceBookCreationDraft
    {
        foreach ($this->rows() as $key => $oldRow) {
            if ($oldRow->id()->value() === $row->id()->value()) {
                unset($this->rows[$key]);
                $this->validate()->thatRowContainsAsManyElementsAsThereAreColumns($row, count($this->columns()));
                $this->validate()->thatEveryColumnExists($row, $this->columns());
                $this->validate()->thatThereIsNoSuchRowYet($row, $this->rows());
                $this->validate()->thatRowContainsCorrectValues($row, $this->columns());
                $this->rows[$key] = $row;
            }
        }

        return $this;
    }

    public function update(): ReferenceBookCreationDraft
    {
        $this->updatedBy = $this->lockedBy();
        $this->updatedAt = Carbon::now();
        return $this;
    }

    //PRIVATE

    private function validate(): ReferenceBookCreationDraftValidator
    {
        return $this->validator;
    }
}
