<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\NodeTypes\Space;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\NodeTypes\UserGroup;

final readonly class SpaceNode
{

    private function __construct(
        public string $uniqueName,
        public string $label,
        public array  $roomNodes,
        public array  $roleNodes,
        public array  $userGroupNodes
    )
    {

    }

    /**
     * @param string $uniqueName
     * @param string $label
     * @param Space[]|null $spaces
     * @param array|null $rooms
     * @param array|null $userGroups
     * @param array|null $roles
     * @return static
     */
    public static function new(
        string $uniqueName,
        string $label,
        ?array $spaces,
        ?array $rooms,
        ?array $userGroups,
        ?array $roles,
    ): self
    {
        return new self(...get_defined_vars());
    }
}