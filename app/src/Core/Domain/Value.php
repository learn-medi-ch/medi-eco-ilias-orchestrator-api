<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain;

//todo move those values to a separate service
use MediEco\IliasUserOrchestratorOrbital\Core\Ports\Tree\RoleStructure;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports\Tree\RoomStructure;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports\Tree\SpaceStructure;

class Value
{
    private function __construct()
    {

    }

    public static function new(): self
    {
        return new self();
    }

    public function string(string $string): StringValue
    {
        return StringValue::new($string);
    }

    public function path(array $segments): PathValue
    {
        return PathValue::fromArray($segments);
    }

    public function object(object $object): ObjectValue
    {
        return ObjectValue::new($object);
    }

    public function array(array $string): ArrayValue
    {
        return ArrayValue::new($string);
    }

    public function room(string $name, string $parentUniqueId): Tree\RoomNode
    {
        return Tree\RoomNode::new($this->string($name), $this->string($this->path([$parentUniqueId, $name])));
    }

    public function role(string $name, string $parentUniqueId): Tree\RoleNode
    {
        return Tree\RoleNode::new($this->string($name), $this->string($this->path([$parentUniqueId, $name])));
    }

    public function spaceNode(SpaceStructure $spaceStructure, ?string $uniqueIdParent = null): Tree\SpaceNode
    {

        $nameValue = $this->string($spaceStructure->name());
        $uniqueIdValue = $nameValue->transform(fn($name) => $this->path([$uniqueIdParent, $name]));
        $spacesValue = $this->array($spaceStructure->spaces())->map(fn(SpaceStructure $spaceStructure) => $this->spaceNode($spaceStructure, $uniqueIdValue));
        $roomsValue = $this->array($spaceStructure->rooms())->map(fn(RoomStructure $roomStructure) => $this->room($roomStructure->name(), $uniqueIdValue));
        $roleValue = $this->array($spaceStructure->roles())->map(fn(RoleStructure $roleStructure) => $this->role($roleStructure->name(), $uniqueIdValue));

        return Tree\SpaceNode::new($nameValue, $uniqueIdValue, $spacesValue, $roomsValue, $roleValue);
    }
}