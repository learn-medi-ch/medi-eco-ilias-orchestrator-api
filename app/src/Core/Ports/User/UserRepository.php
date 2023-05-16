<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\User;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain;

interface UserRepository
{

    public function get(Domain\ValueObjects\UserImportId $userId): null|UserDto;

    public function getUserByImportId(
        string $importId
    ): ?Domain\ValueObjects\MediStudentData;

    public function create(
        Domain\ValueObjects\UserData $userData
    ): void;


    public function update(
        Domain\ValueObjects\UserData $userData
    ): void;

}