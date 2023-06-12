<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Tree;

final readonly class SpaceNode
{
    /**
     * @param string $name
     * @param string $uniqueName
     * @param SpaceNode[] $spaceNodes
     * @param RoomNode[] $roomNodes
     * @param RoleNode[] $roleNodes
     */
    private function __construct(
        public string $name,
        public string $uniqueName,
        public array  $spaceNodes,
        public array  $roomNodes,
        public array  $roleNodes,
    )
    {

    }

    /**
     * @param string $name
     * @param string $uniqueName
     * @param SpaceNode[] $spaceNodes
     * @param RoomNode[] $roomNodes
     * @param RoleNode[] $roleNodes
     * @return static
     *
     * //todo think about state params -> lazy loading?
     */
    public static function new(
        string $name,
        string $uniqueName,
        array  $spaceNodes,
        array  $roomNodes,
        array  $roleNodes,
    ): self
    {
        return new self(...get_defined_vars());
    }
}