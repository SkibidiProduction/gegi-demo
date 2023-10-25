<?php

namespace Application\Context\ReferenceBooks\ReferenceBook\Actions;

use Application\Context\ReferenceBooks\ReferenceBook\Dto\CreateReferenceBookCreationDraftDto;
use Application\Context\ReferenceBooks\ReferenceBook\Tasks\CreateReferenceBookCreationDraftTask;
use Application\Context\ReferenceBooks\ReferenceBook\ViewModels\ReferenceBookCreationDraftPayload;
use Application\Shared\Tasks\Transactions\TransactionTask;
use Throwable;

final class CreateReferenceBookCreationDraftAction
{
    public function __construct(
        private readonly CreateReferenceBookCreationDraftTask $createReferenceBookCreationDraftTask,
        private readonly TransactionTask $transactionTask
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(CreateReferenceBookCreationDraftDto $dto): ReferenceBookCreationDraftPayload
    {
        $referenceBookCreationDraft = $this->transactionTask->run(function () use ($dto) {
            return $this->createReferenceBookCreationDraftTask->run($dto);
        });

        return new ReferenceBookCreationDraftPayload($referenceBookCreationDraft);
    }
}
