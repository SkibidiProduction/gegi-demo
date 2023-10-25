<?php

namespace Application\Context\ReferenceBooks\Row\Tasks;

use Application\Context\ReferenceBooks\Column\Dto\AddRowToReferenceBookCreationDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftRepository;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookColumnDoesntExistException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowAlreadyExistsException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowNumericValueHasIncorrectFormatException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowStringValueHasIncorrectFormatException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowValuesHasWrongNumberException;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Context\ReferenceBooks\Row\Row;
use Domain\Context\ReferenceBooks\Row\ValueObjects\Value;
use Domain\Shared\Events\EventDispatcher;
use Throwable;

class AddRowToReferenceBookCreationDraftTask
{
    public function __construct(
        private readonly ReferenceBookCreationDraftRepository $repository,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @param AddRowToReferenceBookCreationDraftDto $dto
     * @return ReferenceBookCreationDraft
     * @throws ReferenceBookColumnDoesntExistException
     * @throws ReferenceBookRowAlreadyExistsException
     * @throws ReferenceBookRowNumericValueHasIncorrectFormatException
     * @throws ReferenceBookRowStringValueHasIncorrectFormatException
     * @throws ReferenceBookRowValuesHasWrongNumberException
     * @throws Throwable
     */
    public function run(AddRowToReferenceBookCreationDraftDto $dto): ReferenceBookCreationDraft
    {
        $referenceBookCreationDraft = $this->repository->findById($dto->getReferenceBookCreationDraftId());
        $row = new Row();
        $uuidValue = new Value($row->id()->value(), $referenceBookCreationDraft->uuidColumnId());
        $row->addValue($uuidValue);

        foreach ($dto->getValues() as $value) {
            $row->addValue($value);
        }

        $referenceBookCreationDraft->addRow($row);
        $this->repository->update($referenceBookCreationDraft);
        $this->eventDispatcher->dispatch($referenceBookCreationDraft);

        return $referenceBookCreationDraft;
    }
}
