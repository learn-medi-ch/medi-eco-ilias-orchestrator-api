<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\NodeTypes\UserGroup;

final readonly class UserGroupNode
{
    private function __construct(
        public string $uniqueName,
        public string $label,
        ?array $roles,
    )
    {

    }

    /**
     * @param string $uniqueName
     * @param string $label
     */
    public static function new(
        string $uniqueName,
        string $label,
        ?array $roles,
    ): self
    {
        return new self(...get_defined_vars());
    }

}
