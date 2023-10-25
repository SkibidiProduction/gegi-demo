<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook;

use Carbon\Carbon;
use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookColumnAlreadyExistsException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowAlreadyExistsException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowValuesHasWrongNumberException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookUnsupportedStatusChangeException;
use Domain\Context\ReferenceBooks\ReferenceBook\Proxy\ColumnUpdateDraftProxy;
use Domain\Context\ReferenceBooks\ReferenceBook\Proxy\RowUpdateDraftProxy;
use Domain\Context\ReferenceBooks\ReferenceBook\Services\GetEachRowWithNewColumnDefaultValueService;
use Domain\Context\ReferenceBooks\ReferenceBook\Validators\ReferenceBookUpdateDraftValidator;
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

final class ReferenceBookUpdateDraft implements AggregateRoot, Lockable
{
    use EventTrait;
    use LockTrait;

    private Id $id;
    private Status $status;
    private Name $name;
    private Code $code;
    private ?Status $statusPrevious = null;
    private Carbon $createdAt;
    private ?Carbon $updatedAt;
    private ?Id $createdBy;
    private ?Id $updatedBy;
    private Type $type;
    private ?Description $description;

    /** @var ColumnUpdateDraftProxy|array<Column>  */
    private ColumnUpdateDraftProxy|array $columns;

    /** @var RowUpdateDraftProxy|array<Row>  */
    private RowUpdateDraftProxy|array $rows;
    private ReferenceBookUpdateDraftValidator $validator;

    /**
     * @throws Throwable
     */
    public function __construct(private readonly ReferenceBook $referenceBook)
    {
        $this->id = $this->referenceBook->id();
        $this->status = $this->referenceBook->status();
        $this->statusPrevious = $this->referenceBook->statusPrevious();
        $this->name = $this->referenceBook->name();
        $this->code = $this->referenceBook->code();
        $this->type = $this->referenceBook->type();
        $this->description = $this->referenceBook->description();
        $this->columns = $this->referenceBook->columns();
        $this->rows = $this->referenceBook->rows();
        $this->createdAt = $this->referenceBook->createdAt();
        $this->updatedAt = $this->referenceBook->updatedAt();
        $this->type = $this->referenceBook->type();
        $this->createdBy = $this->referenceBook->createdBy();
        $this->updatedBy = $this->referenceBook->updatedBy();
        $this->validator = new ReferenceBookUpdateDraftValidator();
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

    public function columns(): array
    {
        if ($this->columns instanceof ColumnUpdateDraftProxy) {
            $this->columns = $this->columns->get();
        }
        return $this->columns;
    }

    public function rows(): array
    {
        if ($this->rows instanceof RowUpdateDraftProxy) {
            $this->rows = $this->rows->get();
        }
        return $this->rows;
    }

    //MUTATORS
    /**
     * @throws ReferenceBookUnsupportedStatusChangeException
     */
    public function updateStatus(Status $status): self
    {
        $this->validate()->thatStatusTransitionIsPossible($this->status, $status);

        $this->statusPrevious = $this->status;

        $this->status = new Status($status->asEnum(), $this->lockedBy(), Carbon::now());

        $this->update();

        return $this;
    }

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
    public function addColumn(Column $column): ReferenceBookUpdateDraft
    {
        $this->validate()->thatNewColumnIsUnique($this->columns(), $column);
        $column->setReferenceBookId($this->id);
        $this->columns[] = $column;
        $this->rows = GetEachRowWithNewColumnDefaultValueService::run($this->rows(), $column);
        $this->update();
        return $this;
    }

    /**
     * @throws ReferenceBookRowAlreadyExistsException
     * @throws ReferenceBookRowValuesHasWrongNumberException
     */
    public function addRow(Row $row): ReferenceBookUpdateDraft
    {
        $this->validate()->thatRowContainsAsManyElementsAsThereAreColumns($row, count($this->columns()));
        $this->validate()->thatThereIsNoSuchRowYet($row, $this->rows());

        $this->rows[] = $row;
        $this->update();

        return $this;
    }

    public function updateRow(Row $row): ReferenceBookUpdateDraft
    {
        foreach ($this->rows() as $key => $oldRow) {
            if ($oldRow->id()->value() === $row->id()->value()) {
                $this->rows[$key] = $row;
            }
        }

        return $this;
    }

    public function deleteRow(Id $rowId): void
    {
        foreach ($this->rows() as $key => $row) {
            if ($row->id()->value() === $rowId->value()) {
                unset($this->rows[$key]);
            }
        }

        $this->rows = array_values($this->rows);
    }

    public function update(): ReferenceBookUpdateDraft
    {
        $this->updatedBy = $this->lockedBy();
        $this->updatedAt = Carbon::now();
        return $this;
    }

    //PRIVATE

    private function validate(): ReferenceBookUpdateDraftValidator
    {
        return $this->validator;
    }
}
