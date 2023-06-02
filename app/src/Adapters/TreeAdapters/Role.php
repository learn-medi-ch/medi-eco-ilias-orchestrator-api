<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\TreeAdapters;

use  MediEco\IliasUserOrchestratorOrbital\Core\Ports\Tree;

enum Role: string implements Tree\Role
{
    case VIEW = "view";
    case EDIT = "edit";
    case ADMINISTRATE = "administrate";

    function name(): string
    {
        return $this->value;
    }
}
