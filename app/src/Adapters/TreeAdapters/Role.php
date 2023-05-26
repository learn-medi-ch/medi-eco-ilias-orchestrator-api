<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\TreeAdapters;

use  MediEco\IliasUserOrchestratorOrbital\Core\Ports\TreePorts;

enum Role: string implements TreePorts\Role
{
    case VIEW = "view";
    case EDIT = "edit";
    case ADMINISTRATE = "administrate";

    function name(): string
    {
        return $this->value;
    }
}
