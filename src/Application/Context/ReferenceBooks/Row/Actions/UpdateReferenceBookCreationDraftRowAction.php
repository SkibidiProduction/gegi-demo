<?php

namespace Application\Context\ReferenceBooks\Row\Actions;

use Application\Context\ReferenceBooks\Column\Dto\UpdateReferenceBookCreationDraftRowDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Application\Context\ReferenceBooks\ReferenceBook\ViewModels\ReferenceBookCreationDraftPayload;
use Application\Context\ReferenceBooks\Row\Tasks\UpdateReferenceBookCreationDraftRowTask;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\CantAddRowWithNonExistingColumnException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookColumnDoesntExistException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowAlreadyExistsException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowNumericValueHasIncorrectFormatException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowStringValueHasIncorrectFormatException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowValuesHasWrongNumberException;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

class UpdateReferenceBookCreationDraftRowAction
{
    public function __construct(
        private readonly ReferenceBookCreationDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @param UpdateReferenceBookCreationDraftRowDto $dto
     * @return ReferenceBookCreationDraftPayload
     * @throws ReferenceBookColumnDoesntExistException
     * @throws CantAddRowWithNonExistingColumnException
     * @throws ReferenceBookRowAlreadyExistsException
     * @throws ReferenceBookRowNumericValueHasIncorrectFormatException
     * @throws ReferenceBookRowStringValueHasIncorrectFormatException
     * @throws ReferenceBookRowValuesHasWrongNumberException
     * @throws Throwable
     */
    public function run(UpdateReferenceBookCreationDraftRowDto $dto): ReferenceBookCreationDraftPayload
    {
        $updateRowTask = new UpdateReferenceBookCreationDraftRowTask($this->repository, $this->eventDispatcher);
        $referenceBookCreationDraft = $updateRowTask->run($dto);
        return new ReferenceBookCreationDraftPayload($referenceBookCreationDraft);
    }
}
