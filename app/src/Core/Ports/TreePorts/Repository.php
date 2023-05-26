<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\TreePorts;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\Tree\{RoleNode, RoomNode, SpaceNode, UserGroup};

interface Repository
{
    public function getByParentUniqueName(string $parentUniqueName): null|RoleNode|RoomNode|SpaceNode|UserGroup;

    public function create(string $parentUniqueName, string $uniqueName, string $label): void;
}