<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Factories;

use Application\Context\ReferenceBooks\ReferenceBook\Proxy\SqlColumnsProxy;
use Application\Context\ReferenceBooks\ReferenceBook\Proxy\SqlRowsProxy;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookRepository;
use Carbon\Carbon;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBook;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Code\Code;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Description\Description;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\ReferenceBookType\Type;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Status\Status;
use Domain\Shared\ValueObjects\Id\Id;
use ReflectionException;
use Throwable;

class ReferenceBookBuilder
{
    protected Id $id;
    protected Name $name;
    protected Code $code;
    protected Type $type;
    protected Status $status;
    protected ?Status $statusPrevious;
    protected ?Description $description;
    protected Carbon $createdAt;
    protected ?Carbon $updatedAt;
    protected Id $createdBy;
    protected ?Id $updatedBy;
    protected ?Id $editor;

    public function withId(Id $id): ReferenceBookBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function withName(Name $name): ReferenceBookBuilder
    {
        $this->name = $name;
        return $this;
    }

    public function withCode(Code $code): ReferenceBookBuilder
    {
        $this->code = $code;
        return $this;
    }

    public function withType(Type $type): ReferenceBookBuilder
    {
        $this->type = $type;
        return $this;
    }

    public function withStatus(Status $status): ReferenceBookBuilder
    {
        $this->status = $status;
        return $this;
    }

    public function withStatusPrevious(?Status $statusPrevious): ReferenceBookBuilder
    {
        $this->statusPrevious = $statusPrevious;
        return $this;
    }

    public function withDescription(?Description $description): ReferenceBookBuilder
    {
        $this->description = $description;
        return $this;
    }

    public function withCreatedAt(Carbon $createdAt): ReferenceBookBuilder
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function withUpdatedAt(?Carbon $updatedAt): ReferenceBookBuilder
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function withCreatedBy(Id $createdBy): ReferenceBookBuilder
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function withUpdatedBy(?Id $updatedBy): ReferenceBookBuilder
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    public function withEditor(?Id $editor): ReferenceBookBuilder
    {
        $this->editor = $editor;
        return $this;
    }

    /**
     * @param ReferenceBookRepository $repository
     * @return ReferenceBook
     * @throws ReflectionException
     * @throws Throwable
     */
    public function restore(ReferenceBookRepository $repository): ReferenceBook
    {
        $reflection = new \ReflectionClass(ReferenceBook::class);
        $referenceBook = $reflection->newInstanceWithoutConstructor();
        $id = $this->id ?? Id::new();
        $reflection->getProperty('id')->setValue($referenceBook, $id);
        $reflection->getProperty('name')->setValue($referenceBook, $this->name);
        $reflection->getProperty('code')->setValue($referenceBook, $this->code);
        $reflection->getProperty('type')->setValue($referenceBook, $this->type);
        $reflection->getProperty('description')->setValue($referenceBook, $this->description);
        $reflection->getProperty('status')->setValue($referenceBook, $this->status);
        $reflection->getProperty('statusPrevious')->setValue($referenceBook, $this->statusPrevious);
        $reflection->getProperty('createdAt')->setValue($referenceBook, $this->createdAt);
        $reflection->getProperty('updatedAt')->setValue($referenceBook, $this->updatedAt);
        $reflection->getProperty('createdBy')->setValue($referenceBook, $this->createdBy);
        $reflection->getProperty('updatedBy')->setValue($referenceBook, $this->updatedBy);
        $reflection->getProperty('editor')->setValue($referenceBook, $this->editor);
        $reflection->getProperty('columns')->setValue($referenceBook, new SqlColumnsProxy($id, $repository->columns()));
        $reflection->getProperty('rows')->setValue($referenceBook, new SqlRowsProxy($id, $repository->rows()));
        return $referenceBook;
    }
}
