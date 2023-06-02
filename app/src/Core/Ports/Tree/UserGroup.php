<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Tree;


interface UserGroup
{
    function name(): string;

    /**
     * @return ?Role[]
     */
    function roles(): ?array;


    /**
     * @return ?RoomStructure[]
     */
    function rooms(): ?array;
}