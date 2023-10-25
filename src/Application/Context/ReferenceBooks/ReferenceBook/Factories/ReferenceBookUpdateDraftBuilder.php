<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Factories;

use Application\Context\ReferenceBooks\ReferenceBook\Proxy\SqlColumnUpdateDraftProxy;
use Application\Context\ReferenceBooks\ReferenceBook\Proxy\SqlRowUpdateDraftProxy;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookUpdateDraftRepository;
use Carbon\Carbon;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookUpdateDraft;
use Domain\Context\ReferenceBooks\ReferenceBook\Validators\ReferenceBookUpdateDraftValidator;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Code\Code;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Description\Description;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\ReferenceBookType\Type;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Status\Status;
use Domain\Shared\ValueObjects\Id\Id;
use ReflectionException;
use Throwable;

class ReferenceBookUpdateDraftBuilder
{
    protected Id $id;
    protected Name $name;
    protected Code $code;
    protected Type $type;
    protected Status $status;
    protected ?Status $statusPrevious = null;
    protected ?Description $description;
    protected Carbon $createdAt;
    protected ?Carbon $updatedAt;
    protected Id $createdBy;
    protected ?Id $updatedBy;
    protected ?Id $editor;

    public function withId(Id $id): ReferenceBookUpdateDraftBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function withName(Name $name): ReferenceBookUpdateDraftBuilder
    {
        $this->name = $name;
        return $this;
    }

    public function withCode(Code $code): ReferenceBookUpdateDraftBuilder
    {
        $this->code = $code;
        return $this;
    }

    public function withType(Type $type): ReferenceBookUpdateDraftBuilder
    {
        $this->type = $type;
        return $this;
    }

    public function withStatus(Status $status): ReferenceBookUpdateDraftBuilder
    {
        $this->status = $status;
        return $this;
    }

    public function withStatusPrevious(?Status $statusPrevious): ReferenceBookUpdateDraftBuilder
    {
        $this->statusPrevious = $statusPrevious;
        return $this;
    }

    public function withDescription(?Description $description): ReferenceBookUpdateDraftBuilder
    {
        $this->description = $description;
        return $this;
    }

    public function withCreatedAt(Carbon $createdAt): ReferenceBookUpdateDraftBuilder
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function withUpdatedAt(?Carbon $updatedAt): ReferenceBookUpdateDraftBuilder
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function withCreatedBy(Id $createdBy): ReferenceBookUpdateDraftBuilder
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function withUpdatedBy(?Id $updatedBy): ReferenceBookUpdateDraftBuilder
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    public function withEditor(?Id $editor): ReferenceBookUpdateDraftBuilder
    {
        $this->editor = $editor;
        return $this;
    }

    /**
     * @param ReferenceBookUpdateDraftRepository $repository
     * @return ReferenceBookUpdateDraft
     * @throws ReflectionException
     * @throws Throwable
     */
    public function restore(ReferenceBookUpdateDraftRepository $repository): ReferenceBookUpdateDraft
    {
        $reflection = new \ReflectionClass(ReferenceBookUpdateDraft::class);
        $referenceBookUpdateDraft = $reflection->newInstanceWithoutConstructor();
        $reflection->getProperty('id')->setValue($referenceBookUpdateDraft, $this->id);
        $reflection->getProperty('name')->setValue($referenceBookUpdateDraft, $this->name);
        $reflection->getProperty('code')->setValue($referenceBookUpdateDraft, $this->code);
        $reflection->getProperty('type')->setValue($referenceBookUpdateDraft, $this->type);
        $reflection->getProperty('description')->setValue($referenceBookUpdateDraft, $this->description);
        $reflection->getProperty('status')->setValue($referenceBookUpdateDraft, $this->status);
        $reflection->getProperty('statusPrevious')->setValue($referenceBookUpdateDraft, $this->statusPrevious);
        $reflection->getProperty('createdAt')->setValue($referenceBookUpdateDraft, $this->createdAt);
        $reflection->getProperty('updatedAt')->setValue($referenceBookUpdateDraft, $this->updatedAt);
        $reflection->getProperty('createdBy')->setValue($referenceBookUpdateDraft, $this->createdBy);
        $reflection->getProperty('updatedBy')->setValue($referenceBookUpdateDraft, $this->updatedBy);
        $reflection->getProperty('editor')->setValue($referenceBookUpdateDraft, $this->editor);
        $reflection->getProperty('validator')->setValue($referenceBookUpdateDraft, new ReferenceBookUpdateDraftValidator());
        $reflection->getProperty('columns')->setValue(
            $referenceBookUpdateDraft,
            new SqlColumnUpdateDraftProxy($this->id, $repository->columns())
        );
        $reflection->getProperty('rows')->setValue(
            $referenceBookUpdateDraft,
            new SqlRowUpdateDraftProxy($this->id, $repository->rows())
        );
        return $referenceBookUpdateDraft;
    }
}
