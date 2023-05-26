<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\TreePorts;


interface UserGroup
{
    function name(): string;

    /**
     * @return ?Role[]
     */
    function roles(): ?array;


    /**
     * @return ?Room[]
     */
    function rooms(): ?array;
}