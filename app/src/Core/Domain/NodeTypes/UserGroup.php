<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\NodeTypes;


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