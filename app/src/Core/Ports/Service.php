<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain;

final class Service
{

    private function __construct(
        private Domain\Value $value
    )
    {

    }

    public static function new(): Service
    {
        return new self(Domain\Value::new());
    }

    public function createTree(
        Tree\SpaceStructure $spaceStructure
    ): Domain\Tree\SpaceNode
    {
        return $this->createSpaceNode($spaceStructure);
    }

    public function createSpaceNode(Tree\SpaceStructure $spaceStructure, ?string $uniqueIdParent = null): Domain\Tree\SpaceNode
    {
        $value = $this->value;

        $nameValue = $value->string($spaceStructure->name());
        $uniqueIdValue = $nameValue->transform(fn($name) => $value->path([$uniqueIdParent, $name]));
        $spacesValue = $value->array($spaceStructure->spaces())->map(fn(Tree\SpaceStructure $spaceStructure) => $this->createSpaceNode($spaceStructure, $uniqueIdValue));
        $roomsValue = $value->array($spaceStructure->rooms())->map(fn(Tree\RoomStructure $roomStructure) => Domain\Tree\RoomNode::new($roomStructure->name(), $value->path([$uniqueIdValue, $roomStructure->name()])));
        $roleValue = $value->array($spaceStructure->roles())->map(fn(Tree\RoleStructure $roleStructure) => Domain\Tree\RoomNode::new($roleStructure->name(), $value->path([$uniqueIdValue, $roleStructure->name()])));

        return Domain\Tree\SpaceNode::new($nameValue, $uniqueIdValue, $spacesValue, $roomsValue, $roleValue);
    }

}