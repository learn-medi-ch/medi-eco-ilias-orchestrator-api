<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\User;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain;

interface UserRepository
{

    public function get(Domain\ValueObjects\MediUserImportId $userId): null|UserDto;

    public function getUserByImportId(
        string $importId
    ): ?Domain\ValueObjects\UserData;

    public function create(
        Domain\ValueObjects\UserData $userData
    ): void;


    public function update(
        Domain\ValueObjects\UserData $userData
    ): void;

    /**
     * @param string $userImportId
     * @return string[]
     */
    public function getSubscribedRoleImportIds(
        string $userImportId
    ): array;

    public function subscribeToRole(
        string $userImportId, $roleImportId
    ): void;

}