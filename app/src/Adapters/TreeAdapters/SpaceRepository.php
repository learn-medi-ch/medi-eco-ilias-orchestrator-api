<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\TreeAdapters;

use FluxIliasBaseApi\Adapter\Role\RoleDiffDto;
use FluxIliasRestApiClient\Adapter\Api\IliasRestApiClient;
use MediEco\IliasUserOrchestratorOrbital\Core;
use MediEco\IliasUserOrchestratorOrbital\Core\{Domain\Tree\RoleNode,
    Domain\Tree\RoomNode,
    Domain\Tree\SpaceNode,
    Domain\Tree\UserGroup,
    Ports\TreePorts,
    Domain,
    Ports\User\UserDto};

final readonly class SpaceRepository implements TreePorts\Repository
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

    public function createLocalRole(string $parentImportId, string $importId, string $title)
    {
        $this->iliasRestApiClient->createRoleToImportId($parentImportId, RoleDiffDto::new(
            $importId,
            $title,
            ""
        ));
    }

    public function getByParentUniqueName(string $parentUniqueName): null|RoleNode|RoomNode|SpaceNode|UserGroup
    {
        // TODO: Implement getByParentUniqueName() method.
    }

    public function create(string $parentUniqueName, string $uniqueName, string $label): void
    {
        // TODO: Implement create() method.
    }
}