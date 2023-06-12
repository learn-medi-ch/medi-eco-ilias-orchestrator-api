<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config\Lms;

use  MediEco\IliasUserOrchestratorOrbital\Core\Ports\Lms;

enum RoleType: string implements Lms\Role
{
    case VIEW = "view";
    case EDIT = "edit";
    case ADMINISTRATE = "administrate";

    function name(): string
    {
        return $this->value;
    }
}