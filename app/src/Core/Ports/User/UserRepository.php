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

}