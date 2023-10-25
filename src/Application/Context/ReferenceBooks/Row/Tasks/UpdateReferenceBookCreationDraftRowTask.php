<?php

namespace Application\Context\ReferenceBooks\Row\Tasks;

use Application\Context\ReferenceBooks\Column\Dto\UpdateReferenceBookCreationDraftRowDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\CantAddRowWithNonExistingColumnException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookColumnDoesntExistException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowAlreadyExistsException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowNumericValueHasIncorrectFormatException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowStringValueHasIncorrectFormatException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowValuesHasWrongNumberException;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

class UpdateReferenceBookCreationDraftRowTask
{
    public function __construct(
        private readonly ReferenceBookCreationDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @param UpdateReferenceBookCreationDraftRowDto $dto
     * @return ReferenceBookCreationDraft
     * @throws ReferenceBookColumnDoesntExistException
     * @throws CantAddRowWithNonExistingColumnException
     * @throws ReferenceBookRowAlreadyExistsException
     * @throws ReferenceBookRowNumericValueHasIncorrectFormatException
     * @throws ReferenceBookRowStringValueHasIncorrectFormatException
     * @throws ReferenceBookRowValuesHasWrongNumberException
     * @throws Throwable
     */
    public function run(UpdateReferenceBookCreationDraftRowDto $dto): ReferenceBookCreationDraft
    {
        $referenceBookCreationDraft = $this->repository->findById($dto->getReferenceBookCreationDraftId());
        $rowId = null;

        foreach ($dto->getValues() as $value) {
            if ($value->columnId()->value() === $referenceBookCreationDraft->uuidColumnId()->value()) {
                $rowId = $value->value();
            }
        }

        foreach ($referenceBookCreationDraft->rows() as $row) {
            if ($row->id()->value() === $rowId) {
                $oldValues = $row->values();
                foreach ($oldValues as $iValue) {
                    $row->removeValue($iValue);
                }
                foreach ($dto->getValues() as $newValue) {
                    $row->addValue($newValue);
                }
                $referenceBookCreationDraft->updateRow($row);
            }
        }

        $this->repository->update($referenceBookCreationDraft);

        $this->eventDispatcher->dispatch($referenceBookCreationDraft);

        return $referenceBookCreationDraft;
    }
}
