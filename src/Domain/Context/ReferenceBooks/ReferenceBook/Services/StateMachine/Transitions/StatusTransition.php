<?php

namespace Domain\Context\ReferenceBooks\ReferenceBook\Services\StateMachine\Transitions;

use Domain\Context\ReferenceBooks\ReferenceBook\Enums\StatusEnum;
use Domain\Shared\Services\StateMachine\Transition;

class StatusTransition implements Transition
{
    public function getTransitions(): array
    {
        return [
            StatusEnum::New->value => [
                StatusEnum::Active->value,
            ],
            StatusEnum::Active->value => [
                StatusEnum::Archive->value,
            ],
            StatusEnum::Archive->value => [
                StatusEnum::Active->value,
            ],
        ];
    }
}
