<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain;

use MediEco\IliasUserOrchestratorOrbital\Core\Ports;

class Service
{
    private function __construct(
        private Ports\States\Service $stateService
    )
    {

    }

    public static function new(
        Ports\States\Service $stateService
    ): self
    {
        return new self($stateService);
    }

    public function newRoomNode(Ports\Lms\Room $room, string $uniqueIdParent): Tree\RoomNode
    {
        $nameValue = $this->stateService->newStringState($room->name());
        $uniqueIdValue = $nameValue->transform(fn($name) => $this->stateService->newPathState([$uniqueIdParent, $name]));

        return Tree\RoomNode::new($nameValue, $uniqueIdValue);
    }

    public function newRoleNode(string $name, string $parentUniqueId): Tree\RoleNode
    {
        return Tree\RoleNode::new($this->stateService->newStringState($name), $this->stateService->newStringState($this->stateService->newPathState([$parentUniqueId, $name])));
    }

    public function newSpaceNode(Ports\Lms\Space $space, ?string $uniqueIdParent = null): Tree\SpaceNode
    {

        $currentSpaceNodeName = $this->stateService->newStringState($space->name());
        $currentSpaceNodeUniqueId = $currentSpaceNodeName->transform(fn($name) => $this->stateService->newPathState([$uniqueIdParent, $name]));

        $childSpaces = $this->stateService->newArrayState($space->spaces())->map(fn(Ports\Lms\Space $space) => $this->newSpaceNode($space, $currentSpaceNodeUniqueId))->value();
        $childRoomes = $this->stateService->newArrayState($space->rooms())->map(fn(Ports\Lms\Room $room) => $this->newRoomNode($room, $currentSpaceNodeUniqueId))->value();

        /*$roleValue = $this->newArrayState($spaceStructure->roles())->map(
            fn($value) => $this->newArrayState($value)->maybe(
                fn(Ports\Lms\Role $roleStructure) => $this->newRoleNode($roleStructure->name(), $uniqueIdValue)
            )
        );*/ //todo - simplify? @see \MediEco\IliasUserOrchestratorOrbital\Core\Ports\Service::createTree


        return Tree\SpaceNode::new($currentSpaceNodeName, $currentSpaceNodeUniqueId, $childSpaces, $childRoomes, []);
    }
}