<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Tree;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\Tree\Space;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\Tree\UserGroup;

final readonly class SpaceNode
{

    private function __construct(
        public string $uniqueName,
        public string $label,
        public ?array $spaces,
        public ?array $rooms,
        public ?array $roles,
        public ?array $userGroups
    )
    {

    }

    /**
     * @param string $uniqueName
     * @param string $label
     * @param array|null $spaces
     * @param array|null $rooms
     * @param array|null $userGroups
     * @param array|null $roles
     * @return static  //todo
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