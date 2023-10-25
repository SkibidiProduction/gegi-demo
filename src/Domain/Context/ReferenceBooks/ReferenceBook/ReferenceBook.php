<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook;

use Carbon\Carbon;
use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Context\ReferenceBooks\ReferenceBook\Enums\StatusEnum;
use Domain\Context\ReferenceBooks\ReferenceBook\Proxy\ColumnProxy;
use Domain\Context\ReferenceBooks\ReferenceBook\Proxy\RowProxy;
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

final class ReferenceBook implements AggregateRoot, Lockable
{
    use EventTrait;
    use LockTrait;

    private Id $id;
    private Status $status;
    private Name $name;
    private Code $code;
    private Type $type;
    private ?Description $description;
    private ?Status $statusPrevious = null;
    private Carbon $createdAt;
    private ?Carbon $updatedAt;
    private ?Id $createdBy;
    private ?Id $updatedBy;

    /** @var ColumnProxy|array<Column>  */
    private ColumnProxy|array $columns;

    /** @var RowProxy|array<Row>  */
    private RowProxy|array $rows;

    /**
     * @param ReferenceBookCreationDraft $referenceBookCreationDraft
     */
    public function __construct(private readonly ReferenceBookCreationDraft $referenceBookCreationDraft)
    {
        $this->id = $this->referenceBookCreationDraft->id();
        $this->status = new Status(StatusEnum::New);
        $this->name = $this->referenceBookCreationDraft->name();
        $this->code = $this->referenceBookCreationDraft->code();
        $this->type = $this->referenceBookCreationDraft->type();
        $this->description = $this->referenceBookCreationDraft->description();
        $this->columns = $this->referenceBookCreationDraft->columns();
        $this->rows = $this->referenceBookCreationDraft->rows();
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();
        $this->createdBy = $this->referenceBookCreationDraft->lockedBy();
        $this->updatedBy = $this->referenceBookCreationDraft->lockedBy();
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

    public function createdBy(): ?Id
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
        if ($this->columns instanceof ColumnProxy) {
            $this->columns = $this->columns->get();
        }
        return $this->columns;
    }

    /**
     * @return array<Row>
     */
    public function rows(): array
    {
        if ($this->rows instanceof RowProxy) {
            $this->rows = $this->rows->get();
        }
        return $this->rows;
    }

    //MUTATORS

    public function update(ReferenceBookUpdateDraft $referenceBookUpdateDraft): ReferenceBook
    {
        $this->id = $referenceBookUpdateDraft->id();
        $this->status = $referenceBookUpdateDraft->status();
        $this->statusPrevious = $referenceBookUpdateDraft->statusPrevious();
        $this->name = $referenceBookUpdateDraft->name();
        $this->code = $referenceBookUpdateDraft->code();
        $this->type = $referenceBookUpdateDraft->type();
        $this->description = $referenceBookUpdateDraft->description();
        $this->columns = $referenceBookUpdateDraft->columns();
        $this->rows = $referenceBookUpdateDraft->rows();
        $this->createdAt = $referenceBookUpdateDraft->createdAt();
        $this->updatedAt = Carbon::now();
        $this->createdBy = $referenceBookUpdateDraft->createdBy();
        $this->updatedBy = $referenceBookUpdateDraft->lockedBy();

        return $this;
    }
}
