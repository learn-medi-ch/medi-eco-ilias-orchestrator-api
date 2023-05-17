<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Role;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain;

interface RoleRepository
{
    public function getRoleByRoleByImportId(string $importId): ?Domain\ValueObjects\Role;
    public function createGlobalRole(string $importId, string $title): void;

    public function createLocalRole(string $parentImportId, string $importId, string $title);
}