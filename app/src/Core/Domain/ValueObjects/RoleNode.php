<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\NodeTypes\Role;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\NodeTypes\Room;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\NodeTypes\UserGroup;

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
