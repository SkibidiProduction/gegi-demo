<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\DeleteReferenceBookCreationDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Tasks\DeleteReferenceBookCreationDraftTask;
use Application\Context\ReferenceBooks\ReferenceBook\ViewModels\ReferenceBookCreationDraftPayload;
use Application\Shared\Tasks\Transactions\TransactionTask;

class DeleteReferenceBookCreationDraftAction
{
    public function __construct(
        private readonly DeleteReferenceBookCreationDraftTask $deleteReferenceBookDraftTask,
        private readonly TransactionTask $transactionTask,
    ) {
    }
    public function run(DeleteReferenceBookCreationDraftDto $dto): ReferenceBookCreationDraftPayload
    {
        $referenceBookCreationDraft = $this->transactionTask->run(
            fn () => $this->deleteReferenceBookDraftTask->run($dto)
        );

        return new ReferenceBookCreationDraftPayload($referenceBookCreationDraft);
    }
}
