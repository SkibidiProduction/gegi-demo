<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Factories;

use Application\Context\ReferenceBooks\ReferenceBook\Proxy\SqlColumnsCreationDraftProxy;
use Application\Context\ReferenceBooks\ReferenceBook\Proxy\SqlRowsCreationDraftProxy;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Carbon\Carbon;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Context\ReferenceBooks\ReferenceBook\Validators\ReferenceBookCreationDraftValidator;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Code\Code;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Description\Description;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\ReferenceBookType\Type;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Status\Status;
use Domain\Shared\ValueObjects\Id\Id;
use ReflectionException;
use Throwable;

class ReferenceBookCreationDraftBuilder
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
    protected ReferenceBookCreationDraftValidator $validator;

    public function withId(Id $id): ReferenceBookCreationDraftBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function withName(Name $name): ReferenceBookCreationDraftBuilder
    {
        $this->name = $name;
        return $this;
    }

    public function withCode(Code $code): ReferenceBookCreationDraftBuilder
    {
        $this->code = $code;
        return $this;
    }

    public function withType(Type $type): ReferenceBookCreationDraftBuilder
    {
        $this->type = $type;
        return $this;
    }

    public function withStatus(Status $status): ReferenceBookCreationDraftBuilder
    {
        $this->status = $status;
        return $this;
    }

    public function withDescription(?Description $description): ReferenceBookCreationDraftBuilder
    {
        $this->description = $description;
        return $this;
    }

    public function withCreatedAt(Carbon $createdAt): ReferenceBookCreationDraftBuilder
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function withUpdatedAt(?Carbon $updatedAt): ReferenceBookCreationDraftBuilder
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function withCreatedBy(Id $createdBy): ReferenceBookCreationDraftBuilder
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function withUpdatedBy(?Id $updatedBy): ReferenceBookCreationDraftBuilder
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    public function withEditor(?Id $editor): ReferenceBookCreationDraftBuilder
    {
        $this->editor = $editor;
        return $this;
    }

    public function withValidator(ReferenceBookCreationDraftValidator $validator): ReferenceBookCreationDraftBuilder
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * @param ReferenceBookCreationDraftRepository $repository
     * @return ReferenceBookCreationDraft
     * @throws ReflectionException
     * @throws Throwable
     */
    public function restore(ReferenceBookCreationDraftRepository $repository): ReferenceBookCreationDraft
    {
        $reflection = new \ReflectionClass(ReferenceBookCreationDraft::class);
        $referenceBookCreationDraft = $reflection->newInstanceWithoutConstructor();
        $reflection->getProperty('id')->setValue($referenceBookCreationDraft, $this->id);
        $reflection->getProperty('name')->setValue($referenceBookCreationDraft, $this->name);
        $reflection->getProperty('code')->setValue($referenceBookCreationDraft, $this->code);
        $reflection->getProperty('type')->setValue($referenceBookCreationDraft, $this->type);
        $reflection->getProperty('description')->setValue($referenceBookCreationDraft, $this->description);
        $reflection->getProperty('status')->setValue($referenceBookCreationDraft, $this->status);
        $reflection->getProperty('createdAt')->setValue($referenceBookCreationDraft, $this->createdAt);
        $reflection->getProperty('updatedAt')->setValue($referenceBookCreationDraft, $this->updatedAt);
        $reflection->getProperty('createdBy')->setValue($referenceBookCreationDraft, $this->createdBy);
        $reflection->getProperty('updatedBy')->setValue($referenceBookCreationDraft, $this->updatedBy);
        $reflection->getProperty('editor')->setValue($referenceBookCreationDraft, $this->editor);
        $reflection->getProperty('validator')->setValue(
            $referenceBookCreationDraft,
            new ReferenceBookCreationDraftValidator()
        );
        $reflection->getProperty('columns')->setValue(
            $referenceBookCreationDraft,
            new SqlColumnsCreationDraftProxy($this->id, $repository->columns())
        );
        $reflection->getProperty('rows')->setValue(
            $referenceBookCreationDraft,
            new SqlRowsCreationDraftProxy($this->id, $repository->rows())
        );
        return $referenceBookCreationDraft;
    }
}
