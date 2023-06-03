<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Tree;


interface UserGroup
{
    function name(): string;

    /**
     * @return ?RoleStructure[]
     */
    function roles(): ?array;


    /**
     * @return ?RoomStructure[]
     */
    function rooms(): ?array;
}