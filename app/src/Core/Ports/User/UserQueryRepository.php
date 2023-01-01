<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\User;

interface UserQueryRepository
{
    /**
     * @param string $contextId
     * @return UserDto[]
     */
    public function getFacultyUsers(string $contextId): array;
}