<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\NodeTypes\Role;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\NodeTypes\Room;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\NodeTypes\Space;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\NodeTypes\UserGroup;

final readonly class Tree
{
    public SpaceNode $rootNode;

    private function __construct(
        private LabelDictionary $dictionary,
        Space                   $rootSpace
    )
    {
        $this->rootNode = $this->createSpaceNode($rootSpace, null);
    }

    public static function new(LabelDictionary $dictionary, Space $rootSpace): self
    {
        return new self(...get_defined_vars());
    }

    private function createUniqueName(
        string  $name,
        ?string $parentPath
    )
    {
        return match ($parentPath) {
            null => Path::new([$name])->toKebabCase(),
            default => Path::new([$parentPath, $name])->toKebabCase()
        };
    }

    private function createSpaceNode(
        Space   $space,
        ?string $uniqueNameParent
    ): SpaceNode
    {
        $uniqueName = $this->createUniqueName($space->name(), $uniqueNameParent);

        return SpaceNode::new(
            $uniqueName,
            $this->label($uniqueName),
            $this->createSpaceNodes($space->spaces(), $uniqueName),
            $this->createRoomNodes($space->rooms(), $uniqueName),
            $this->createUserGroupNodes($space->userGroups(), $uniqueName),
            $this->createRoleNodes($space->roles(), $uniqueName),
        );
    }

    private function label(string $uniqueName): string {
        //todo
        return $this->dictionary->get(Language::DE, $uniqueName)
    }

    private function createSpaceNodes(
        ?array  $spaces,
        ?string $uniqueNameParent
    ): ?array
    {
        return match ($spaces) {
            null => null,
            default => array_map(
                fn($space) => $this->createSpaceNode($space, $uniqueNameParent),
                $spaces
            )
        };
    }

    private function createRoomNodes(
        ?array  $rooms,
        ?string $uniqueNameParent
    )
    {
        return match ($rooms) {
            null => null,
            default => array_map(
                fn($room) => $this->createRoomNode($room, $uniqueNameParent),
                $rooms
            )
        };
    }

    private function createRoomNode(
        Room    $room,
        ?string $uniqueNameParent
    )
    {
        $uniqueName = $this->createUniqueName($room->name(), $uniqueNameParent);

        return RoomNode::new(
            $uniqueName,
            $this->dictionary->label($uniqueName)
        );
    }

    private function createUserGroupNodes(
        ?array  $userGroups,
        ?string $uniqueNameParent
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
        UserGroup $userGroup,
        ?string   $uniqueNameParent
    )
    {
        $uniqueName = $this->createUniqueName($userGroup->name(), $uniqueNameParent);

        return UserGroupNode::new(
            $uniqueName,
            $this->dictionary->label($uniqueName),
            $this->createRoleNodes($userGroup->roles(), $uniqueName)
        );
    }

    private function createRoleNodes(
        ?array  $roles,
        ?string $uniqueNameParent
    ): ?array
    {
        return match ($roles) {
            null => null,
            default => array_map(
                fn($role) => $this->createRoleNode($role, $uniqueNameParent),
                $roles
            )
        };
    }

    private function createRoleNode(
        Role    $role,
        ?string $uniqueNameParent
    )
    {
        $uniqueName = $this->createUniqueName($role->name(), $uniqueNameParent);

        return RoleNode::new(
            $uniqueName,
            $this->dictionary->label($uniqueName),
        );
    }
}