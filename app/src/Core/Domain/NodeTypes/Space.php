<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\NodeTypes;


interface Space
{
    public function name(): string;
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