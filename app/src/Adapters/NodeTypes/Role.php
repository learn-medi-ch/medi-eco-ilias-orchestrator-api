<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\NodeTypes;

use  MediEco\IliasUserOrchestratorOrbital\Core\Domain;

enum Role: string implements Domain\NodeTypes\Role
{
    case VIEW = "view";
    case EDIT = "edit";
    case ADMINISTRATE = "administrate";

    function name(): string
    {
        return $this->value;
    }
}
