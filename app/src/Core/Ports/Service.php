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
        return $this->value->spaceNode($spaceStructure);
    }

}