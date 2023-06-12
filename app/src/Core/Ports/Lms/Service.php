<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Lms;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\Tree\{RoleNode, RoomNode, SpaceNode, UserGroup};

interface Service
{
    /**
    public function getByParentUniqueName(string $parentUniqueName): null|RoleNode|RoomNode|SpaceNode|UserGroup;

    public function create(string $parentUniqueName, string $uniqueName, string $label): void;
     **/

    public function initRootSpace();

    public function createOrUpdateSpace(string $parentUniqueName, string $uniqueName): void;

    public function createOrUpdateRoom(string $parentUniqueName, string $uniqueName): void;
}