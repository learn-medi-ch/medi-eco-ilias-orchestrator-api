<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\TreeAdapters;

use FluxIliasBaseApi\Adapter\Category\CategoryDiffDto;
use FluxIliasBaseApi\Adapter\Category\CategoryDto;
use FluxIliasBaseApi\Adapter\Role\RoleDiffDto;
use FluxIliasRestApiClient\Adapter\Api\IliasRestApiClient;
use MediEco\IliasUserOrchestratorOrbital\Core;
use MediEco\IliasUserOrchestratorOrbital\Core\{Domain\Tree\RoleNode,
    Domain\Tree\RoomNode,
    Domain\Tree\SpaceNode,
    Domain\Tree\UserGroup,
    Ports\Tree,
    Domain,
    Ports\User\UserDto};

final readonly class RoleRepository implements Tree\Repository
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

    public function getCategoryByImportId(string $importId): ?Domain\ValueObjects\MediCategory
    {
        $category = $this->iliasRestApiClient->getCategoryByImportId($importId);
        return match ($category) {
            null => null,
            default => Domain\ValueObjects\MediCategory::fromImportId(
                $category->import_id,
                $category->title
            )
        };
    }

    public function createCategoryToRootNode(string $importId, string $title): void
    {
        $refId = 1; //todo
        $this->iliasRestApiClient->createCategoryToRefId($refId, CategoryDiffDto::new(
            $importId,
            $title
        ));
    }

    public function createCategory(string $parentImportId, string $importId, string $title): void
    {
        $this->iliasRestApiClient->createCategoryToImportId(
            $parentImportId,
            CategoryDiffDto::new(
                $importId,
                $title
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