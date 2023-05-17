<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Repositories\IliasRole;

use FluxIliasBaseApi\Adapter\Role\RoleDiffDto;
use FluxIliasRestApiClient\Adapter\Api\IliasRestApiClient;
use MediEco\IliasUserOrchestratorOrbital\Core;
use MediEco\IliasUserOrchestratorOrbital\Core\{Ports, Domain, Ports\User\UserDto};

final readonly class IliasRoleRepository implements Ports\Role\RoleRepository
{
    private function __construct(
        private IliasRestApiClient $iliasRestApiClient,
    )
    {

    }

    public static function new(IliasRestApiClient $iliasRestApiClient): self
    {
        return new self(
            $iliasRestApiClient
        );
    }

    public function getRoleByRoleByImportId(string $importId): ?Domain\ValueObjects\MediRole
    {
        $role = $this->iliasRestApiClient->getRoleByImportId($importId);
        return match ($role) {
            null => null,
            default => Domain\ValueObjects\MediRole::new(
                $role->import_id,
                $role->id,
                $role->title
            )
        };
    }

    public function createGlobalRole(string $importId, string $title): void
    {
        $refId = 8; //todo
        $this->iliasRestApiClient->createRoleToRefId($refId, RoleDiffDto::new(
            $importId,
            $title,
            ""
        ));
    }
}