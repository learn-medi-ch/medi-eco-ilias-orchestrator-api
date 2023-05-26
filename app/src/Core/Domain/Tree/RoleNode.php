<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Tree;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\Tree\Role;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\Tree\Room;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\Tree\UserGroup;

final readonly class RoleNode
{
    private function __construct(
        public string $uniqueName,
        public string $label
    )
    {

    }

    /**
     * @param string $uniqueName
     * @param string $label
     */
    public static function new(
        string $uniqueName,
        string $label
    ): self
    {
        return new self(...get_defined_vars());
    }

}
