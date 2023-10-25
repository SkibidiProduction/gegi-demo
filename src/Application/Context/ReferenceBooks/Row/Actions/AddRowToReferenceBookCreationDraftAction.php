<?php

namespace Application\Context\ReferenceBooks\Row\Actions;

use Application\Context\ReferenceBooks\Column\Dto\AddRowToReferenceBookCreationDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Application\Context\ReferenceBooks\ReferenceBook\ViewModels\ReferenceBookCreationDraftPayload;
use Application\Context\ReferenceBooks\Row\Tasks\AddRowToReferenceBookCreationDraftTask;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowAlreadyExistsException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowValuesHasWrongNumberException;
use Domain\Shared\Events\EventDispatcher;
use Infrastructure\Context\ReferenceBooks\Row\Dto\AddRowToReferenceBookCreationDraftSpatieDto;
use Throwable;

class AddRowToReferenceBookCreationDraftAction
{
    public function __construct(
        private readonly ReferenceBookCreationDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @param AddRowToReferenceBookCreationDraftSpatieDto $dto
     * @return ReferenceBookCreationDraftPayload
     * @throws ReferenceBookRowAlreadyExistsException
     * @throws ReferenceBookRowValuesHasWrongNumberException
     * @throws Throwable
     */
    public function run(AddRowToReferenceBookCreationDraftDto $dto): ReferenceBookCreationDraftPayload
    {
        $addRowTask = new AddRowToReferenceBookCreationDraftTask($this->repository, $this->eventDispatcher);
        $referenceBookCreationDraft = $addRowTask->run($dto);
        return new ReferenceBookCreationDraftPayload($referenceBookCreationDraft);
    }
}
