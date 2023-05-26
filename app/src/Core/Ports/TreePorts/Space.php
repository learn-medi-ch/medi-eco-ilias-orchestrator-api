<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\TreePorts;


interface Space
{
    public function parentUnqieName(): string;
    public function uniqueName(): string;
    /**
     * @return ?Space[]
     */
    public function spaces(): ?array;
    /**
     * @return ?Room[]
     */
    public function rooms(): ?array;

    /**
     * @return ?UserGroup[]
     */
    public function userGroups(): ?array;

    /**
     * @return ?Role[]
     */
    public function roles(): ?array;
}