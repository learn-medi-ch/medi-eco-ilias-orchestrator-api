<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\User;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects\UserData;

interface UserQueryRepository
{
    /**
     * @param string $contextId
     * @return UserData[]
     */
    public function getFacultyUsers(string $contextId): array; //todo return array of DomainUsers
}