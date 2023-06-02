<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Tree;

use MediEco\IliasUserOrchestratorOrbital\Core\Ports\Tree;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\Label\Dictionary;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\Label\Language;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects\UserGroupNode;

final class TreeAggregate
{
    public ?SpaceNode $rootNode = null;

    private function __construct(
        private readonly Dictionary $dictionary
    )
    {

    }

    public static function new(Dictionary $dictionary): self
    {
        return new self(...get_defined_vars());
    }

    public function create(string $uniqueNameParent, Tree\SpaceStructure $rootSpace): SpaceNode
    {
        $this->createSpaceNode($uniqueNameParent, $rootSpace);
        return $this->rootNode;
    }

    private function createUniqueName(
        string $parentPath,
        string $name,
    ): string
    {
        return Path::new([$parentPath, $name])->toKebabCase();
    }

    private function createSpaceNode(
        string              $uniqueNameParent,
        Tree\SpaceStructure $space,
    ): SpaceNode
    {
        $uniqueName = $this->createUniqueName($space->name(), $uniqueNameParent);

        return SpaceNode::new(
            $uniqueName,
            $this->label($uniqueName),
            $this->createSpaceNodes($uniqueName, $space->spaces()),
            $this->createRoomNodes($uniqueName, $space->rooms()),
            $this->createUserGroupNodes($uniqueName, $space->userGroups()),
            $this->createRoleNodes($uniqueName, $space->roles()),
        );
    }

    private function label(string $uniqueName): string
    {
        return $this->dictionary->read($uniqueName);
    }

    private function createSpaceNodes(
        string $uniqueNameParent,
        ?array $spaces,
    ): ?array
    {
        return match ($spaces) {
            null => null,
            default => array_map(
                fn($space) => $this->createSpaceNode($uniqueNameParent, $space),
                $spaces
            )
        };
    }

    private function createRoomNodes(
        string $uniqueNameParent,
        ?array $rooms
    )
    {
        return match ($rooms) {
            null => null,
            default => array_map(
                fn($room) => $this->createRoomNode($uniqueNameParent, $room),
                $rooms
            )
        };
    }

    private function createRoomNode(
        string         $uniqueNameParent,
        Tree\RoomStructure $room
    )
    {
        $uniqueName = $this->createUniqueName($uniqueNameParent, $room->name());

        return RoomNode::new(
            $uniqueName,
            $this->label($uniqueName)
        );
    }

    private function createUserGroupNodes(
        string $uniqueNameParent,
        ?array $userGroups,
    ): ?array
    {
        return match ($userGroups) {
            null => null,
            default => array_map(
                fn($userGroup) => $this->createUserGroupNode($userGroup, $uniqueNameParent),
                $userGroups
            )
        };
    }

    private function createUserGroupNode(
        string              $uniqueNameParent,
        Tree\UserGroup $userGroup,
    )
    {
        $uniqueName = $this->createUniqueName($uniqueNameParent, $userGroup->name());

        return UserGroupNode::new(
            $uniqueName,
            $this->label($uniqueName),
            $this->createRoleNodes($uniqueName, $userGroup->roles())
        );
    }

    private function createRoleNodes(
        string $uniqueNameParent,
        ?array $roles,
    ): ?array
    {
        return match ($roles) {
            null => null,
            default => array_map(
                fn($role) => $this->createRoleNode($uniqueNameParent, $role),
                $roles
            )
        };
    }

    private function createRoleNode(
        string         $uniqueNameParent,
        Tree\Role $role,
    )
    {
        $uniqueName = $this->createUniqueName($uniqueNameParent, $role->name());

        return RoleNode::new(
            $uniqueName,
            $this->label($uniqueName)
        );
    }
}