<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Lms;

interface Space
{
    public function name(): string;
    /**
     * @return Space[]
     */
    public function spaces(): array;
    /**
     * @return Room[]
     */
    public function rooms(): array;

    /**
     * @return UserGroup[]
     */
    public function userGroups(): array;

    /**
     * @return ?Role[]
     */
    public function roles(): ?array;
}