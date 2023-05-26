<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\Attributes\{Id, Text};

final readonly class Hub
{
    private function __construct(
        Id    $id,
        Text $label
    )
    {

    }
}