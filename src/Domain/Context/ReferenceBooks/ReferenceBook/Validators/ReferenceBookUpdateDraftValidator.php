<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Validators;

use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookColumnAlreadyExistsException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowAlreadyExistsException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookRowValuesHasWrongNumberException;
use Domain\Context\ReferenceBooks\ReferenceBook\Exceptions\ReferenceBookUnsupportedStatusChangeException;
use Domain\Context\ReferenceBooks\ReferenceBook\Services\StateMachine\Transitions\StatusTransition;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Status\Status;
use Domain\Context\ReferenceBooks\Row\Row;
use Domain\Shared\Services\StateMachine\CheckTransitionAvailableService;

class ReferenceBookUpdateDraftValidator
{
    /**
     * @param array<Column> $existColumns
     * @param Column $newColumn
     * @return void
     * @throws ReferenceBookColumnAlreadyExistsException
     */
    public function thatNewColumnIsUnique(array $existColumns, Column $newColumn): void
    {
        foreach ($existColumns as $existColumn) {
            if ($newColumn->id()->value() === $existColumn->id()->value()
                || $newColumn->name()->value() === $existColumn->name()->value()) {
                throw new ReferenceBookColumnAlreadyExistsException();
            }
        }
    }

    /**
     * @throws ReferenceBookRowValuesHasWrongNumberException
     */
    public function thatRowContainsAsManyElementsAsThereAreColumns(Row $row, int $columnsCount): void
    {
        if (count($row->values()) !== $columnsCount) {
            throw new ReferenceBookRowValuesHasWrongNumberException();
        }
    }

    /**
     * @param Row $row
     * @param array<Row> $existRows
     * @return void
     * @throws ReferenceBookRowAlreadyExistsException
     */
    public function thatThereIsNoSuchRowYet(Row $row, array $existRows): void
    {
        foreach ($existRows as $existRow) {
            if ($existRow->id()->value() === $row->id()->value()) {
                throw new ReferenceBookRowAlreadyExistsException();
            }
        }
    }

    /**
     * @throws ReferenceBookUnsupportedStatusChangeException
     */
    public function thatStatusTransitionIsPossible(Status $oldStatus, Status $newStatus): void
    {
        $statusTransition = new StatusTransition();
        $stateMachine = new CheckTransitionAvailableService($statusTransition);
        if (!$stateMachine->run($oldStatus->asEnum(), $newStatus->asEnum())) {
            throw new ReferenceBookUnsupportedStatusChangeException();
        }
    }
}
