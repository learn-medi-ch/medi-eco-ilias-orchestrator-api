<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Tree;

interface SpaceStructure
{
    public function name(): string;
    /**
     * @return SpaceStructure[]
     */
    public function spaces(): array;
    /**
     * @return RoomStructure[]
     */
    public function rooms(): array;

    /**
     * @return UserGroup[]
     */
    public function userGroups(): array;

    /**
     * @return ?RoleStructure[]
     */
    public function roles(): ?array;
}